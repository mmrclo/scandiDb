<?php 
//namespace controls\Database;

class Database {
    
    private $host = 'eu-cdbr-west-01.cleardb.com';
    private $db_name = 'heroku_95708d33a35746e';
    private $username = 'b04d2c13f761f4';
    private $password = '7eec9c5e';
    private $conn;

    /*$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);*/

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