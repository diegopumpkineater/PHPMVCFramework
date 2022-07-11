<?php
/*
Database class

*/

/*

Database class namespace

*/

namespace app\Core; //cores main namespace


class Database
{


    public \PDO $pdo;


    public function __construct($config)
    {
        $dns = $config["dns"];
        $username = $config["user"];
        $password = $config["pass"];
        $this->pdo = new \PDO($dns, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applymigrations()
    {
        $this->createmigrationtable();
        $appliedmigrations = $this->getappliedmigrations();
        $files = scandir(Application::$ROOT_DIRECTORY . "/Migrations");

        $notappliedmigrations = array_diff($files, $appliedmigrations);
        $newapplymigrations = [];
        foreach ($notappliedmigrations as $migration) {
            if ($migration === "." || $migration === "..") {
                continue;
            } else {
                include_once Application::$ROOT_DIRECTORY . "/Migrations/$migration";
                $classname = pathinfo($migration, PATHINFO_FILENAME);
                $instance = new $classname();
                $this->log("Applying migration");
                $instance->up();
                $this->log("applied migration");
                $newapplymigrations[] = $migration;
            }
        }

        if (!empty($newapplymigrations)) {
            $this->savemigration($newapplymigrations);
        } else {
            $this->log("All migrations applied");
        }
    }


    public function createmigrationtable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration varchar(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getappliedmigrations()
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function savemigration(array $migrations)
    {
        $str = implode(",", array_map(fn ($m) => "('$m')", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $stmt->execute();
    }

    public function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '=>' . ']' . $message . "\n";
    }
}
