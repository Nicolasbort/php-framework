<?php

require_once('src/Core/Application.php');
require_once('src/Controllers/AuthController.php');
require_once('src/Controllers/SiteController.php');

$app = new Application();

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

$app->run();