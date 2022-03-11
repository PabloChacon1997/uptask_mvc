<?php


namespace Controllers;

use MVC\Router;

class DashboardController {
  public static function index(Router $router) {
    isAuth();
    $titulo = 'Proyectos';
    $router->render('dashboard/index', [
      'titulo' => $titulo,
    ]);
  }

  public static function crear_proyecto(Router $router) {
    isAuth();
    $titulo = 'Crear Proyecto';
    $router->render('dashboard/crear-proyecto', [
      'titulo' => $titulo,
    ]);
  }

  public static function perfil(Router $router) {
    isAuth();
    $titulo = 'Perfil';
    $router->render('dashboard/perfil', [
      'titulo' => $titulo,
    ]);
  }
}