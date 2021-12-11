<?php
namespace MedDocs\Core;

class Router
{
    /**
     * @var string
     */
    private $lastRoute = null;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Response
     */
    protected $response;
    

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback): self
    {
        $this->lastRoute = $path;

        $this->routes['get'][$path] = $callback;

        return $this;
    }

    public function post(string $path, $callback): self
    {
        $this->lastRoute = $path;

        $this->routes['post'][$path] = $callback;

        return $this;
    }

    public function middleware(AbstractMiddleware $middleware): self
    {
        $this->middlewares[$this->lastRoute] = $middleware;
        
        return $this;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $middleware = $this->middlewares[$path] ?? null;
        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('404');
        }

        $success = $middleware ? $middleware->handle() : true;

        if (!$success) {
            $this->response->setStatusCode(401);
            return $this->renderView('/login');
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)){
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback);
    }

    public function renderView($viewName, $params = [])
    {
        $layoutContent = $this->layoutContent($viewName, $params);
        $viewContent = $this->renderOnlyView($viewName, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function layoutContent($viewName, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once "src/Views/layouts/main.php";

        return ob_get_clean();
    }

    private function renderOnlyView($viewName, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once "src/Views/$viewName.php";

        return ob_get_clean();
    }
}