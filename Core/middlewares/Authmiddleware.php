<?php
/*
Authmiddleware class

*/

/*

Authmiddleware class namespace

*/

namespace app\Core\middlewares; //middleware main namespace

use app\Core\Application;
use app\Core\exceptions\Forbiddenexception;

class Authmiddleware extends Basemiddleware
{
    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (!Application::isguest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new Forbiddenexception();
            }
        }
    }
}
