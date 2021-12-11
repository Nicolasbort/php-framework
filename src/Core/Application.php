<?php

namespace MedDocs\Core;
class Application
{
    /**
     * @var Router
     */
    public $router;

    /**
     * @var Session
     */
    public $session;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Application
     */
    public static $app;

    public function __construct()
    {
        self::$app = $this;
        
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}