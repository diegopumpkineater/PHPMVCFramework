<?php
/*
Controller class

*/

/*

controller class namespace

*/

namespace app\Core; //cores main namespace

use app\Core\middlewares\Basemiddleware;

class Controller
{
    public $layout = "main";
    public $action = "";

    public array $middlewares = [];

    public function setlayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }


    public function setmiddlewares(Basemiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getmiddlewares()
    {
        return $this->middlewares;
    }
}
