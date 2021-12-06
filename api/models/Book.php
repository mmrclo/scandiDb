<?php
//namespace \model\Book;

include_once './models/Product.php';

//use \model\Product as Product;

class Book extends Product
{
    protected $spectablename = 'books';
    protected $weight;

    public function __construct() 
    {    
        $this->spec_name = 'Book';
    }

    public function __destruct()
    {
        $this->conn = null;
        $this->sku = null;
        $this->name = null;
        $this->price = null;
        $this->spec_name = null;
        $this->weight = null;
    }

    public function setSpecs($data) 
    {
        $this->weight = $data->weight;
    }

    public function prepareSaveQuery() 
    {
        $query = "INSERT INTO $this->spectablename SET product_id = $this->id ,";
        $fieldlist = array('weight');
    
        return array($query,$fieldlist);
    }

    public function prepareGetQuery() {

        $query = 'SELECT '.$this->tablename.'.id, '.$this->tablename.'.sku, '.$this->tablename.'.name, '. $this->tablename.'.price, '.$this->tablename.'.spec_name,'.$this->spectablename.'.weight FROM '.$this->tablename.' JOIN '.$this->spectablename.' ON '.$this->tablename.'.id = '.$this->spectablename.'.product_id ORDER BY id;'; 

        $fieldlist = array('id', 'sku', 'name', 'price', 'spec_name', 'weight');

        return array($query, $fieldlist);
    }
}