<?php
/*
Loginmodel namespace

*/

namespace app\Models;

use app\Core\Application;
use app\Core\DBModel;
use app\Core\Model;

/*
Loginmodel class
*/

class Loginmodel extends Model
{
    public string $email = "";
    public string $password = "";
    public string $logout = "";


    public function getdata($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRE, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRE]
        ];
    }

    public function login()
    {
        $user = Usermodel::finduser(["email" => $this->email]);
        if (!$user) {
            $this->addspecificerror("email", "Email or Password is incorecct");
            $this->addspecificerror("password", "Email or Password is incorecct");
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addspecificerror("password", "Email or Password is incorecct");
            $this->addspecificerror("email", "Email or Password is incorecct");
            return false;
        }

        return Application::$app->login($user);
    }
}
