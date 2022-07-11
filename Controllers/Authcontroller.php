<?php
/*
Authcontroller class

*/

/*

Authcontroller class namespace

*/

namespace app\Controllers; //cores main namespace

use app\Core\Application;
use app\Core\Controller;
use app\Models\Registermodel;
use app\Core\Request;
use app\Core\Response;
use app\Models\Loginmodel;

class Authcontroller extends Controller
{

    public function register(Request $request, Response $response)
    {
        $registermodel = new Registermodel();
        if ($request->isPost()) {
            $registermodel->getdata($request->getbody());
            if ($registermodel->validate() && $registermodel->register()) {
                Application::$app->session->setflash("success", "thanks for registration");
                $response->redirect("/");
            }
        }

        $this->setlayout("main");
        return $this->render("register", [
            "model" => $registermodel
        ]);
    }

    public function login(Request $request, Response $response)
    {
        $loginmodel = new Loginmodel();
        if ($request->isPost()) {
            $loginmodel->getdata($request->getbody());
            if ($loginmodel->validate() && $loginmodel->login()) {
                Application::$app->session->setflash("success", "you logged in");
                $response->redirect("/");
            }
        }
        $this->setlayout("main");
        return $this->render("signin", [
            "model" => $loginmodel
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        if ($request->isPost()) {
            Application::$app->logout();
            $response->redirect("/");
        }

        $response->redirect("/");
    }
}
