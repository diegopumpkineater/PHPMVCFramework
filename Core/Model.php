<?php
/*
Model class

*/

/*

Model class namespace

*/

namespace app\Core; //cores main namespace


abstract class Model
{
    public const RULE_REQUIRE = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";

    public array $errors = [];

    abstract public function rules(): array;

    public function validate()
    {
        $rules = $this->rules();
        foreach ($rules as $key => $rulearray) {
            $value = $this->{$key};
            foreach ($rulearray as $rule) {
                $rulename = $rule;
                if (!is_string($rulename)) {
                    $rulename = $rule[0];
                }
                if ($rulename === self::RULE_REQUIRE && !$value) {
                    $this->adderror(self::RULE_REQUIRE, $key);
                }

                if ($rulename === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->adderror(self::RULE_EMAIL, $key);
                }

                if ($rulename === self::RULE_MIN && strlen($value) < $rule["min"]) {
                    $this->adderror(self::RULE_MIN, $key, $rule);
                }

                if ($rulename === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    $this->adderror(self::RULE_MAX, $key, $rule);
                }
                if ($rulename === self::RULE_MATCH && $value != $this->{$rule["match"]}) {
                    $this->adderror(self::RULE_MATCH, $key, $rule);
                }

                if ($rulename === self::RULE_UNIQUE) {
                    $attr = $rule["unique"];
                    $tablename = "users";
                    $stmt = Application::$app->db->pdo->prepare("SELECT * FROM $tablename where $attr = :$attr");
                    $stmt->bindValue(":$attr", $this->{$attr});
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if ($record) {
                        $this->adderror(self::RULE_UNIQUE, $key, $rule);
                    }
                }
            }
        }

        return empty($this->errors);
    }


    public function adderror($attr, $rule, $params = [])
    {
        $errormessage = $this->errors()[$attr] ?? '';
        foreach ($params as $key => $value) {
            $errormessage = str_replace("{{$key}}", ucfirst($value), $errormessage);
        }
        $this->errors[$rule][] = $errormessage;
    }

    public function errors()
    {
        return [
            self::RULE_REQUIRE => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be same as {match}',
            self::RULE_UNIQUE => "Record with this {unique} already exists"
        ];
    }

    public function addspecificerror($attr, $msg)
    {
        $this->errors[$attr][] = $msg;
    }



    public function haserror($attr)
    {
        return $this->errors[$attr] ?? false;
    }

    public function getfirsterror($attr)
    {
        return $this->errors[$attr][0] ?? false;
    }
}
