<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
        return $this->conn;
    }
}
