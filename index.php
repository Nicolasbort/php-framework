<?php

require_once('src/Core/Application.php');
require_once('src/Controllers/AuthController.php');
require_once('src/Controllers/SiteController.php');
require_once('src/Controllers/ExamController.php');
require_once('src/Controllers/ConsultController.php');

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

// Profile ( verifica apenas se está logado mas não verifica role )
$app->router->get('/profile', [SiteController::class, 'profile']);
$app->router->post('/profile/update', [AuthController::class, 'updateProfile']);

// Paciente
$app->router->get('/patient', [SiteController::class, 'patient']);

// Médico
$app->router->get('/doctor', [SiteController::class, 'doctor']);
$app->router->post('/doctor/createConsult', [ConsultController::class, 'createConsult']);

// Laboratório
$app->router->get('/laboratory', [SiteController::class, 'laboratory']);
$app->router->post('/laboratory/createExam', [ExamController::class, 'createExam']);


$app->router->post('/exams/create', [ExamController::class, 'createExam']);

$app->run();