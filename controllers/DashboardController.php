<?php


namespace Controllers;

use MVC\Router;

use Model\Proyecto;
use Model\Usuario;

class DashboardController {
  public static function index(Router $router) {
    isAuth();
    $id = $_SESSION['id'];
    $titulo = 'Proyectos';
    $proyectos = Proyecto::belongsTo('propietarioId', $id);
    $router->render('dashboard/index', [
      'titulo' => $titulo,
      'proyectos' => $proyectos,
    ]);
  }

  public static function crear_proyecto(Router $router) {
    isAuth();
    $titulo = 'Crear Proyecto';
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = new Proyecto($_POST);
      
      // Validacion
      $alertas = $proyecto->validarProyecto();

      if (empty($alertas)) {
        // Generar una url unica
        $hash = md5(uniqid());
        $proyecto->url = $hash;
        // Almacenar el creador del proyecto
        $proyecto->propietarioId = $_SESSION['id'];
        // Guardar el proyecto
        $proyecto->guardar();
        // Redirreccionar
        header('Location: /proyecto?id='.$proyecto->url);
      }
    }
    $router->render('dashboard/crear-proyecto', [
      'titulo' => $titulo,
      'alertas' => $alertas,
    ]);
  }

  public static function proyecto(Router $router) {
    isAuth();
    $token = $_GET['id'];
    if(!$token) header('Location: /dashboard');
    // Revisar el dueño del proyecto
    $proyecto = Proyecto::where('url', $token);
    $titulo = $proyecto->proyecto;
    if($proyecto->propietarioId !== $_SESSION['id']) {
      header('Location: /dashboard');
    }


    // Renderizando la vista
    $router->render('dashboard/proyecto', [
      'titulo' => $titulo,
    ]);
  }

  public static function perfil(Router $router) {
    isAuth();
    $titulo = 'Perfil';
    $alertas = [];
    $usuario = Usuario::find($_SESSION['id']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarPerfil();
      if (empty($alertas)) {
        // Verificar si ya existe el email
        $existeUsuario = Usuario::where('email', $usuario->email);
        if($existeUsuario && $existeUsuario->id !== $usuario->id) {
          // Mensaje de error
          Usuario::setAlerta('error', 'Email ya existe, por favor ponga otro');
          $alertas = Usuario::getAlertas();
        } else {
          // Guardar el registro
          // Guardar usuario
          $usuario->guardar();
          Usuario::setAlerta('exito', 'Guardado correctamente');
          $alertas = Usuario::getAlertas();
  
          // Asignar el nombre nuevo a la barra
          $_SESSION['nombre'] = $usuario->nombre;
        }
      }
    }
    $router->render('dashboard/perfil', [
      'titulo' => $titulo,
      'alertas' => $alertas,
      'usuario' => $usuario,
    ]);
  }

  public static function cambiar_password(Router $router) {
    isAuth();
    $alertas = [];
    $titulo = "Cmabiar password";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = Usuario::find($_SESSION['id']);
      // Sincronizar con los datos del usuario
      $usuario->sincronizar($_POST);
      $alertas = $usuario->nuevoPassword();
      if(empty($alertas)) {
        $resultado = $usuario->comprobarPassword();
        if($resultado) {
          
          // Asignar el nuevo password
          $usuario->password = $usuario->nuevoPassword;
          // Eliminar propiedades no necesarias
          unset($usuario->passwordActual);
          unset($usuario->nuevoPassword);
          // Hashear el nuevo password
          $usuario->hashPassword();
          // Guardar el nuevo password
          $resultado = $usuario->guardar();
          if($resultado) {
            Usuario::setAlerta('exito', 'Password guardado correctamente');
            $alertas = $usuario->getAlertas();
          }
        } else {
          Usuario::setAlerta('error', 'Password incorrecto');
          $alertas = $usuario->getAlertas();
        }
      }
    }
    $router->render('dashboard/cambiar_password', [
      'titulo' => $titulo,
      'alertas' => $alertas,
    ]);
  }
}