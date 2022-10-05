<?php 
//namespace controls\Database;

class Database {
    
    private $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    private $host = '.cleardb.com';
    private $db_name = 'heroku_';
    private $username = $cleardb_url["user"];
    private $password = $cleardb_url["pass"];
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
