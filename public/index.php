<?php


use Slim\Factory\AppFactory;
use Config\Database;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UserController;
use App\Controllers\MateriaController;
use App\Controllers\AlumnoMateriaController;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\AlumnoMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$conn = new Database;


$app = AppFactory::create();
$app->setBasePath('/SLIM/otraConexionSQL/public');


$app->group('/users', function (RouteCollectorProxy $group) {

   $group->get('[/]',UserController::class.":getAll");

   // $group->post('[/]',UserController::class.":addOne");
   $group->post('[/]',UserController::class.":add");

   $group->post('/login',UserController::class.":login");

   $group->get('/{legajo}',UserController::class.":getOne");

   $group->post('/{legajo}',UserController::class.":updateOne");

   $group->delete('/{id}',UserController::class.":deleteOne");
    

})->add(new JsonMiddleware);


$app->group('/materias', function (RouteCollectorProxy $group) {

   
   $group->post('[/]',MateriaController::class.":add")->add(new AuthMiddleware);
   $group->get('[/]',MateriaController::class.":getMaterias");   
  
    

})->add(new JsonMiddleware);


$app->group('/inscripcion', function (RouteCollectorProxy $group) {

   
   $group->post('/{idMateria}',AlumnoMateriaController::class.":inscripcion")->add(new AlumnoMiddleware);
  
    

})->add(new JsonMiddleware);
//MIDDELWARE
  
$app->run();