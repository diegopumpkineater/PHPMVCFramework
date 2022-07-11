<?php
/*
Sitecontroller class

*/

/*

Sitecontroller class namespace

*/

namespace app\Controllers; //cores main namespace

use app\Core\Controller;
use app\Core\Request;
use app\Core\Response;
use app\Core\middlewares\Authmiddleware;

class Sitecontroller extends Controller
{

    public function __construct()
    {
        $this->setmiddlewares(new Authmiddleware(["main"]));
    }


    public function main(Request $request, Response $response)
    {
        $this->setlayout("main");
        return $this->render("main");
    }
}
