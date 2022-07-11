<?php
/*
Application class

*/

/*

Application class namespace

*/

namespace app\Core; //cores main namespace

use app\Models\Usermodel;

class Application
{
    public static string $ROOT_DIRECTORY;
    public static Application $app;
    public Router $router;
    public Response $response;
    public Request $request;
    public ?Controller $controller = null;
    public $layout = "main";
    public Database $db;
    public Session $session;
    public Usermodel $userclass;
    public ?Usermodel $user;


    public function __construct($ROOT_DIRECTORY, $config)
    {
        self::$ROOT_DIRECTORY = $ROOT_DIRECTORY;
        self::$app = $this;
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->response, $this->request);
        $this->db = new Database($config["db"]);
        $this->session = new Session();
        $this->userclass = new Usermodel();

        $primaryvalue = $this->session->get("user");
        if ($primaryvalue) {
            $this->user = $this->userclass->finduser(["id" => $primaryvalue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setstatuscode($e->getcode());
            echo $this->router->renderView("_err", [
                "expression" => $e
            ]);
        }
    }

    public function login(Usermodel $user)
    {
        $this->user = $user;
        $primarykey = $user->key();
        $primaryvalue = $user->{$primarykey};
        $this->session->set("user", $primaryvalue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isguest()
    {
        return self::$app->user;
    }
}
