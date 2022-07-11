<?php
/*
Registermodel class

*/

/*

Registermodel class namespace

*/

namespace app\Models; //cores main namespace

use app\Core\DBModel;

class Registermodel extends DBModel
{

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;


    public $firstname = "";
    public $lastname = "";
    public $email = "";
    public $password = "";
    public $confirmpassword = "";
    public $logout = "logout";
    public $status = self::STATUS_INACTIVE;

    public function getdata($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRE, self::RULE_EMAIL, [self::RULE_UNIQUE, "unique" => "email"]],
            "firstname" => [self::RULE_REQUIRE],
            "lastname" => [self::RULE_REQUIRE],
            "password" => [self::RULE_REQUIRE, [self::RULE_MIN, "min" => 8], [self::RULE_MAX, "max" => 24]],
            "confirmpassword" => [self::RULE_REQUIRE, [self::RULE_MATCH, "match" => 'password']]
        ];
    }

    public function tablename(): string
    {
        return "users";
    }

    public function attributes(): array
    {
        return ["firstname", "lastname", "email", "password", "status"];
    }

    public function register()
    {
        $options = [
            "cost" => 12
        ];

        $this->password = password_hash($this->password, PASSWORD_BCRYPT, $options);
        return $this->save($this->tablename(), $this->attributes());
    }
}
