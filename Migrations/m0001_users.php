<?php

class m0001_users
{
    public function up()
    {
        $db = app\Core\Application::$app->db;
        $SQL = "CREATE TABLE users(
            id INT AUTO_INCREMENT PRIMARY KEY,
            email varchar(255) NOT NULL,
            password varchar(512) NOT NULL,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = app\Core\Application::$app->db;
        $SQL = "DROP TABLE users";
        $db->pdo->exec($SQL);
    }
}
