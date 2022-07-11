<?php
/*
Session class

*/

/*

Session class namespace

*/

namespace app\Core; //cores main namespace


class Session
{

    public const FLASH_MESSAGES = "flash_messages";

    public function __construct()
    {
        session_start();
        $flashmessages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach ($flashmessages as $key => &$message) {
            $message["remove"] = true;
        }
        $_SESSION[self::FLASH_MESSAGES] = $flashmessages;
    }

    public function setflash($key, $message)
    {
        $_SESSION[self::FLASH_MESSAGES][$key] = [
            "remove" => false,
            "value" => $message
        ];
    }

    public function getflash($key)
    {
        return $_SESSION[self::FLASH_MESSAGES][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        $flashmessages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach ($flashmessages as $key => $message) {
            if ($message["remove"]) {
                unset($flashmessages[$key]);
            }
        }
        $_SESSION[self::FLASH_MESSAGES] = $flashmessages;
    }


    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}
