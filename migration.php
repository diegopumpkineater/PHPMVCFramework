<?php

include_once __DIR__ . "/vendor/autoload.php";

use app\Core\Application;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    "db" => [
        "dns" => $_ENV["DB_DNS"],
        "user" => $_ENV["DB_USER"],
        "pass" => $_ENV["DB_PASS"]
    ]
];

$app = new Application(__DIR__, $config);


$app->db->applymigrations();
