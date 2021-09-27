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

    /**
     * @var Response $privateList
     */
    protected $privateList;

		public function setPrivateList(array $privateList) 
		{
				$this->privateList = $privateList;
		}

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
        $path = $this->request->getPath();

				$prefix = explode('/', $path)[1];
        
        if(in_array($prefix, $this->privateList)) {
          $user = $this->session->getSession('user');

          if(!$user || $user && $user->role != $prefix) {
            $this->session->setFlash('error', 'Você deve estar credenciado para acessar esta página', 'danger');
            echo $this->router->renderView('/login');
          }
        }

        echo $this->router->resolve();
    }
}