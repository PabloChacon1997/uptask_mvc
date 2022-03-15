<?php


namespace Controllers;

use MVC\Router;

use Model\Proyecto;


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
    $router->render('dashboard/perfil', [
      'titulo' => $titulo,
    ]);
  }
}