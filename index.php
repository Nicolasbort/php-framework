<?php

require_once 'vendor/autoload.php';

use MedDocs\Controller\AuthController;
use MedDocs\Controller\SiteController;
use MedDocs\Controller\UserController;
use MedDocs\Core\Application;
use MedDocs\Core\AuthMiddleware;

$authMiddleware = new AuthMiddleware();

/*
  Usages
    # Return a view
    $app->router->get(<PATH>, <VIEW_NAME>)

    # Execute a callback function
    $app->router->get(<PATH>, function() {})

    # Execute a callback class method
    $app->router->get(<PATH>, [<CLASS>, <METHOD_NAME>])
*/

$app = new Application();

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/signup', [SiteController::class, 'signup']);
$app->router->post('/users/login', [AuthController::class, 'login']);
$app->router->post('/users/signup', [AuthController::class, 'signup']);
$app->router->get('/users/logoff', [AuthController::class, 'logoff']);

$app->router->get('/profile', [SiteController::class, 'profile']);
$app->router->post('/profile/update', [UserController::class, 'update']);

$app->router->get('/patient', [SiteController::class, 'patient'])->middleware($authMiddleware);

$app->router->get('/doctor', [SiteController::class, 'doctor']);

$app->router->get('/laboratory', [SiteController::class, 'laboratory']);

$app->router->get('/api/exam', [ExamController::class, 'list']);
$app->router->post('/api/exam', [ExamController::class, 'create']);
$app->router->post('/api/consult', [ConsultController::class, 'create']);

$app->run();