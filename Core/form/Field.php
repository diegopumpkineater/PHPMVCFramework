<?php
/*
Field class

*/

/*

Field class namespace

*/

namespace app\Core\form; //cores main namespace

use app\Core\Model;

class Field
{
    public const TYPE_TEXT = "text";
    public const TYPE_PASS = "password";
    public const TYPE_EMAIL = "email";
    public const TYPE_HIDDEN = "hidden";


    public Model $model;
    public $attr;
    public $type;

    public function __construct(Model $model, $attr)
    {
        $this->model = $model;
        $this->attr = $attr;
        $this->type = self::TYPE_TEXT;
    }

    public function __toString()
    {

        return sprintf(
            '<div class="form-group">
        <label>%s</label>
        <input type="%s" name="%s" value="%s" class="form-control%s">
        <div class="invalid-feedback">
            %s
        </div>
        </div>',
            ucfirst($this->attr),
            $this->type,
            $this->attr,
            $this->model->{$this->attr},
            $this->model->haserror($this->attr) ? ' is-invalid' : '',
            $this->model->getfirsterror($this->attr)
        );
    }

    public function typepassword()
    {
        $this->type = self::TYPE_PASS;
        return $this;
    }

    public function typehidden()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }
}
