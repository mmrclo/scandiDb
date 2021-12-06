<?php 

//namespace controls\Dataaccess;

include_once '../controls/Database.php';

//use controls\Database as Database;

class Table
{
    protected $conn;
    protected $query;
    protected $data_arr;
    protected $lastInId;
    protected $errors;

    public function __construct()
    {
      $this->query = null;
    }

    public function __destruct()
    {
      $this->query = null;
      $this->conn = null;
      $this->query = null;
      $this->data_arr = null;
      $this->lastInId = null;
      $this->errors = null;
    }

    public function connectToDB(){
        $this->conn = new Database();
        $this->conn = $this->conn->connect();
    }

    protected function getAllFromTable($queryfrom,$fieldlist)
    {   
        $query = $queryfrom; 
        
        $stmt = $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $num = $stmt->rowCount();
        if($num > 0) {
            $data_arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $item = array_intersect_key($row, array_flip($fieldlist)); 
                array_push($data_arr, $item);
            }
            $stmt = $this->conn->commit();
            $stmt = null;
            
            return $data_arr;
        } else {
            $stmt = $this->conn->rollback();
            $stmt = null;
            
            return false;
        }  
    }

    protected function checkIfsOnDb($queryfrom, $field, $value)
    {
        $query = $queryfrom;
        $stmt = $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':'.$field.'', $value);
        
        try {
            $stmt->execute();
            $row = $stmt->fetch();
            
            if($row) {
                $stmt = $this->conn->commit();
                $stmt = null;
                return true;
            } else {
                $this->errors = $stmt->errorInfo();
                $stmt = $this->conn->commit();
                $stmt = null;
                return false;
            }
        } catch(PDOException $e) {
            $this->errors = $e->getMessage();
            $stmt = $this->conn->rollback();
            $stmt = null;
            die();
            return false;
        }
    }

    protected function insertRow($queryfrom, $fieldlist, $data)
    {
        $query = $queryfrom;
        foreach ($fieldlist as $item ) {
            $value = $data->$item;
            $query .= "$item='$value', ";
        }
        $query = rtrim($query, ' ,');           
        
        $stmt = $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);

        if($stmt->execute()) {
            $this->lastInId = $this->conn->lastInsertId();
            $stmt = $this->conn->commit();
            $stmt = null;
            return true;
        }

        $stmt = $this->conn->rollback();
        $stmt = null;
       
        return false;
    }

    protected function tryDeleteRow($queryfrom)
    {
        $query = $queryfrom;

        $stmt = $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);

        try { 
            if($stmt->execute()) {
                $stmt = $this->conn->commit();
                $stmt = null;
                return true;
            }
        } catch(PDOException $e) {
            $this->errors = $e->getMessage();
            $stmt = $this->conn->rollback();
            $stmt = null;
            die();
            return false;
        }
    }

    public function setToDatabase($queryfrom, $fieldlist, $data)
    {
        return $this->insertRow($queryfrom, $fieldlist, $data);
    }

    public function getLastInsertId()
    {
        return $this->lastInId;
    }

    public function selectAll($queryfrom,$fieldlist)
    {
        return $this->getAllFromTable($queryfrom,$fieldlist);
    }

    public function selectRowFromDb($queryfrom, $field, $value)
    {
        return $this->checkIfsOnDb($queryfrom, $field, $value);
    }

    public function deleteRow($queryfrom)
    {
        return $this->tryDeleteRow($queryfrom);
    }
}