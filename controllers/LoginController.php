<?php


namespace Controllers;

use MVC\Router;

class LoginController {
  public static function login(Router $router) {
    $titulo = 'Iniciar sesión';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    }

    // Renderizar la vista
    $router->render('auth/login' , [
      'titulo' => $titulo,
    ]);
  }


  public static function logout() {
    echo 'Desde Logout';
  }


  public static function crear(Router $router) {
    $titulo = 'Crear cuenta';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    }

    $router->render('auth/crear' , [
      'titulo' => $titulo,
    ]);
  }

  public static function olvide(Router $router) {
    $titulo = 'Olvide password';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    }

    // renderizar la vista
    $router->render('auth/olvide' , [
      'titulo' => $titulo,
    ]);
  }

  public static function restablecer(Router $router) {
    $titulo = 'Restablecer password';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      
    }
    // renderizar la vista
    $router->render('auth/restablecer' , [
      'titulo' => $titulo,
    ]);
  }

  public static function mensaje(Router $router) {
    $titulo = 'Cuenta creada exitosamente';
    $router->render('auth/mensaje' , [
      'titulo' => $titulo,
    ]);
  }

  public static function confirmar(Router $router) {
    $titulo = 'Confirma tu cuenta UpTask';
    $router->render('auth/confirmar' , [
      'titulo' => $titulo,
    ]);
  }
}