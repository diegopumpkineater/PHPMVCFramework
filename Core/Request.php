<?php
/*
Request class

*/

/*

Request class namespace

*/

namespace app\Core; //cores main namespace


class Request
{

    public function geturl()
    {
        $url = $_SERVER["REQUEST_URI"] ?? "/";
        $qpos = strpos($url, "?");


        if ($qpos === false) {
            return $url;
        } else {
            return substr($url, 0, $qpos);
        }
    }


    public function getmethod()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function isGet()
    {
        if ($this->getmethod() === "get") {
            return true;
        } else {
            return false;
        }
    }

    public function isPost()
    {
        if ($this->getmethod() === "post") {
            return true;
        } else {
            return false;
        }
    }

    public function getBody()
    {
        $body = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
