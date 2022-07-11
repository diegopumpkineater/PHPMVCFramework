<?php

include_once __DIR__ . "/../vendor/autoload.php";

use app\Core\Application;
use app\Controllers\Sitecontroller;
use app\Controllers\Authcontroller;


$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    "db" => [
        "dns" => $_ENV["DB_DNS"],
        "user" => $_ENV["DB_USER"],
        "pass" => $_ENV["DB_PASS"]
    ]
];

$app = new Application(dirname(__DIR__), $config);


$app->run();
