<?php
/*
Registermodel class

*/

/*

Registermodel class namespace

*/

namespace app\Models; //cores main namespace

use app\Core\DBModel;
use app\Core\Application;

class Usermodel extends Registermodel
{

    public static function finduser(array $user)
    {
        //SELECT * FROM users where id = 5;
        $tablename = "users";
        $attributes = array_keys($user);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $query = "SELECT * FROM $tablename where $sql";
        $stmt  = Application::$app->db->pdo->prepare($query);
        foreach ($user as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    public function key()
    {
        return "id";
    }
}
