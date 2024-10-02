<?php

namespace App\Classes;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $db_name = "ecommerce";
    private $username = "root";
    private $password = "P@ssw0rd";
    public $conn;

    public function getConnection(): PDO
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            ); // handle errors
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
