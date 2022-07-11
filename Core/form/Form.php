<?php
/*
Form class

*/

/*

Form class namespace

*/

namespace app\Core\form; //cores main namespace

use app\Core\Model;


class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action ="%s" method="%s">', $action, $method);
        return new Form();
    }


    public function end()
    {
        return '</form>';
    }

    public function field(Model $model, $attr)
    {
        return new Field($model, $attr);
    }
}
