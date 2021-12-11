<?php

namespace MedDocs\Controller;

use MedDocs\Core\Application;

class BaseController
{
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function getRequest()
    {
        return Application::$app->request;
    }

    public function getResponse()
    {
        return Application::$app->response;
    }

    public function setFlash($key, $message, $color = 'primary')
    {
        Application::$app->session->setFlash($key, $message, $color);
    }

    public function getSession()
    {
        return Application::$app->session;
    }

    public function setSession(string $key, $value)
    {
        Application::$app->session->setSession($key, $value);
    }
}
