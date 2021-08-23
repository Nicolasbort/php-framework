<?php

require_once('src/Core/Router.php');
require_once('src/Core/Database.php');
require_once('src/Core/Session.php');
require_once('src/Core/Request.php');
require_once('src/Core/Response.php');

class Application
{
    /**
     * @var Router $router
     */
    public $router;

    /**
     * @var Database $database
     */
    public $database;

    /**
     * @var Session $session
     */
    public $session;

    /**
     * @var Request $request
     */
    public $request;

    /**
     * @var Response $response
     */
    public $response;

    /**
     * @var Application $app
     */
    public static $app;

    public function __construct()
    {
        self::$app = $this;
        
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
        $this->database = new Database();
        $this->session = new Session();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}