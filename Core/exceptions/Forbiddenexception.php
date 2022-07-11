<?php
/*
Forbiddenexception class

*/

/*

Forbiddenexception class namespace

*/

namespace app\Core\exceptions; //middleware main namespace


class Forbiddenexception extends \Exception
{
    protected $message = "you dont have permission";
    protected $code = 403;
}
