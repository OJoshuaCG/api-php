<?php

require_once DIR . '/config/database.php';

class Race {
    private $conn;
    private $table;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
        $this->table = 'races';
    }

    public function getRaceYears(){
        $query = "SELECT DISTINCT year FROM races ORDER BY year DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $years = $stmt->fetchAll();
        return $years;
    }
}