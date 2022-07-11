<?php
/*
DBModel class

*/

/*

DBModel class namespace

*/

namespace app\Core; //cores main namespace


abstract class DBModel extends Model
{

    abstract public function tablename(): string;

    abstract public function attributes(): array;



    public function save($tablename, $attributes)
    {
        $tbname = $tablename;
        $attr = $attributes;
        $params = array_map(fn ($atr) => ":$atr", $attr);
        var_dump($params);
        $query = "INSERT INTO $tbname (" . implode(",", $attr) . ") VALUES
        (" . implode(",", $params) . ")";
        var_dump($query);
        $stmt = Application::$app->db->pdo->prepare($query);

        foreach ($attr as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
