<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
  public static function login(Router $router) {
    $titulo = 'Iniciar sesión';
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validarLogin();

      if (empty($alertas)) {
        // Verificar el usuario exista
        $usuario = Usuario::where('email' , $auth->email);
        if(!$usuario || !$usuario->confirmado) {
          Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
        } else {
          // El usuario existe
          if (password_verify($_POST['password'], $usuario->password)) {
            // Iniciar sesion
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['login'] = true;


            // Redireccion
            header('Location: /dashboard');

          } else {
            Usuario::setAlerta('error', 'El correo y/o constraseña son incorrectos');
          }
        }
      }
    }
    $alertas = Usuario::getAlertas();
    // Renderizar la vista
    $router->render('auth/login' , [
      'titulo' => $titulo,
      'alertas' => $alertas,
    ]);
  }


  public static function logout() {
    $_SESSION = [];
    header('Location: /');
  }


  public static function crear(Router $router) {
    $titulo = 'Crear cuenta';
    $alertas = [];
    $usuario = new Usuario;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarCuenta();
      $existeUsuario = Usuario::where('email', $usuario->email);
      if (empty($alertas)) {
        if($existeUsuario) {
          Usuario::setAlerta('error','El usuario ya esta registrado');
          $alertas = Usuario::getAlertas();
        } else {
          // Hashear el password
          $usuario->hashPassword();
          // Eliminar password 2
          unset($usuario->password2);

          $usuario->generarToken();
          // Crear nuevo usuario
          $resultado = $usuario->guardar();

          // Enviar email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacio();

          if ($resultado) {
            header('Location: /mensaje');
          }
        }
      }
    }

    $router->render('auth/crear' , [
      'titulo' => $titulo,
      'usuario' => $usuario,
      'alertas' => $alertas,
    ]);
  }

  public static function olvide(Router $router) {
    $titulo = 'Olvide password';
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validarEmail();

      if (empty($alertas)) {
        // Buscar el usuario
        $usuario = Usuario::where('email', $usuario->email);
        if($usuario && $usuario->confirmado) {
          // Genrar un nuevo token
          $usuario->generarToken();
          unset($usuario->password2);
          // Actualizar el usuario
          $usuario->guardar();
          // Enviar emal
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarIntrucciones();
          // Imprimir alerta
          Usuario::setAlerta('exito', 'Hemos enviado intrucciones a tu email');

          // debuguear($usuario);
        } else {
          // Usuario no encontrado
          Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
        }
      }
    }
    $alertas = Usuario::getAlertas();
    // renderizar la vista
    $router->render('auth/olvide' , [
      'titulo' => $titulo,
      'alertas' => $alertas,
    ]);
  }

  public static function restablecer(Router $router) {
    $titulo = 'Restablecer password';
    $mostrar = true;
    $token = s($_GET['token']);
    if(!$token) header('Location: /');

    // Identificar el usuario con el token
    $usuario = Usuario::where('token', $token);
    if(empty($usuario)) {
      Usuario::setAlerta('error','Token no válido');
      $mostrar= false;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Añadir el nuevo password
      $usuario->sincronizar($_POST);
      // Validar password
      $alertas = $usuario->validarPassword();
      if(empty($alertas)) {
        // Hshear password
        $usuario->hashPassword();
        // Eliminar token
        $usuario->token = null;
        // Guardar el nuevo password
         $resultado = $usuario->guardar();

        if($resultado) {
          header('Location: /');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    // renderizar la vista
    $router->render('auth/restablecer' , [
      'titulo' => $titulo,
      'alertas' => $alertas,
      'mostrar' => $mostrar,
    ]);
  }

  public static function mensaje(Router $router) {
    $titulo = 'Cuenta creada exitosamente';
    $router->render('auth/mensaje' , [
      'titulo' => $titulo,
    ]);
  }

  public static function confirmar(Router $router) {
    $token = s($_GET['token']);
    if(!$token) header('Location: /');

    // Encontrar al usuario con el token
    $usuario = Usuario::where('token', $token);
    if(empty($usuario)) {
      // No se encontro un usuario con ese token
      Usuario::setAlerta('error', 'Token NO valido');
    } else {
      // Confirmar la cuenta
      $usuario->confirmado = 1;
      $usuario->token = null;
      unset($usuario->password2);

      // Guardar en la BD
      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
    }
    $titulo = 'Confirma tu cuenta UpTask';
    $alertas = Usuario::getAlertas();
    $router->render('auth/confirmar' , [
      'titulo' => $titulo,
      'alertas' => $alertas,
    ]);
  }
}