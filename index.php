<?php

require_once('src/Core/Application.php');
require_once('src/Controllers/AuthController.php');
require_once('src/Controllers/SiteController.php');
require_once('src/Controllers/ExamController.php');

$app = new Application();

$app->setPrivateList(['patient','doctor','laboratory']);

/*
  Usages
    # Return a view
    $app->router->get(<PATH>, <VIEW_NAME>)

    # Execute a callback function
    $app->router->get(<PATH>, function() {})

    # Execute a callback class method
    $app->router->get(<PATH>, [<CLASS>, <METHOD_NAME>])
*/

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/signup', [SiteController::class, 'signup']);
$app->router->post('/users/login', [AuthController::class, 'login']);
$app->router->post('/users/signup', [AuthController::class, 'signup']);
$app->router->get('/users/logoff', [AuthController::class, 'logoff']);

$app->router->get('/patient', [SiteController::class, 'patient']);
$app->router->get('/doctor', [SiteController::class, 'doctor']);

// Laboratório
$app->router->get('/laboratory', [SiteController::class, 'laboratory']);
$app->router->post('/laboratory/createExam', [ExamController::class, 'createExam']);


$app->router->post('/exams/create', [ExamController::class, 'createExam']);

$app->run();