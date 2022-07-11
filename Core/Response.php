<?php
/*
Response class

*/

/*

Response class namespace

*/

namespace app\Core; //cores main namespace


class Response
{
    public function redirect($url)
    {
        header("Location: " . $url);
    }

    public function setstatuscode(int $code)
    {
        http_response_code($code);
    }
}
