<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    // LOCALHOST
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'school_diary';

    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function execute($stmt)
    {
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error: Unable to execute the statement. Please try again later.";
                return false;
            }
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            return false;
        }
    }

    private function connect()
    {
        if (
            $_SERVER['HTTP_HOST'] == 'localhost' ||
            $_SERVER['HTTP_HOST'] == '127.0.0.1'
        ) {
            $this->host = 'localhost';
            $this->username = 'root';
            $this->password = '';
            $this->database = 'school_diary';
        }

        $dsn =
            'mysql:host='. $this->host .
            ';dbname=' . $this->database .
            ';charset=utf8';

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
}
