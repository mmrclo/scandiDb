<?php 
//namespace controls\Database;

class Database {
    
    /*private $host = 'localhost';
    private $db_name = 'id18057629_scandiapp';
    private $username = 'id18057629_roots';
    private $password = '@<Q#7eCuP7Bp6Or~';
    private $conn;
    /* testing 3/12 21:29*/
    private $host = 'localhost';
    private $db_name = 'scandiapp';
    private $username = 'root';
    private $password = 'loopsql741';
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