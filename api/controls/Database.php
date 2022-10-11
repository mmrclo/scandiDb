<?php 
//namespace controls\Database;
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    define("DBHOST", $cleardb_url["host"]);
    define("DBNAME", substr($cleardb_url["path"],1));
    define("USER", $cleardb_url["user"]);
    define("PASSW", $cleardb_url["pass"]);

class Database 
{    
    private $host = DBHOST;
    private $db_name = DBNAME;
    private $username = USER;
    private $password = PASSW;
    private $conn;

    public function connect() {
        $this->conn = null;

        try { 
            $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->username, $this->password, array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => 1
            ));
            echo 'Success con';
            
        } catch(PDOException $e) {
              echo 'Connection Error: ' . $e->getMessage();
              die();
        }

        return $this->conn;
    }
}
