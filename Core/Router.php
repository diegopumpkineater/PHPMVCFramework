<?php
/*
Router class

*/

/*

Router class namespace

*/

namespace app\Core; //cores main namespace


class Router
{

    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Response $response, Request $request)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve()
    {
        $requestmethod = $this->request->getmethod(); // Get request method
        $requesturl = $this->request->geturl(); //Get Request URL

        //vipovot gamodzaxebuli callback 
        $callback = $this->routes[$requestmethod][$requesturl] ?? false;
        if ($callback === false) {
            return "not found";
            //pop error 404
        }

        if (is_string($callback)) {
            //render view
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getmiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        $layout = $this->renderLayout(); //Render layout
        $view = $this->renderOnlyView($view, $params); //Render view
        return str_replace('{{content}}', $view, $layout);
    }


    public function renderLayout()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIRECTORY . "/Views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIRECTORY . "/Views/$view.php";
        return ob_get_clean();
    }
}
