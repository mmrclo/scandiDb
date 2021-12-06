<?php 
//namespace controls\Database;

class Database {
    
    private $host = 'localhost';
    private $db_name = 'eu-cdbr-west-01.cleardb.com';
    private $username = 'b04d2c13f761f4';
    private $password = '7eec9c5e';
    private $conn;

    public function connect() {
        $this->conn = null;

        try { 
            $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->username, $this->password, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => 1
            ));
          
        } catch(PDOException $e) {
              echo 'Connection Error: ' . $e->getMessage();
              die();
        }

        return $this->conn;
    }
}