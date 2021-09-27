<?php

require_once('src/Core/Request.php');
require_once('src/Core/Response.php');

class Router
{
    /**
     * @var array $routes
     */
    protected $routes = [];

    /**
     * @var Request $request
     */
    protected $request;
    
    /**
     * @var Response $response
     */
    protected $response;
    

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get(string $path, $callback): self
    {
        $this->routes['get'][$path] = $callback;

				return $this;
    }

    public function post(string $path, $callback): self
    {
        $this->routes['post'][$path] = $callback;

				return $this;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? null;

        if (!$callback) {
            $this->response->setStatusCode(404);
            return $this->renderView('404');
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