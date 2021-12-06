<?php 
//namespace \model\Dvd;

include_once './models/Product.php';

//use \model\Product as Product;

class Dvd extends Product
{
    protected $spectablename = 'dvd_discs';
    protected $size;

    public function __construct()
    {
        $this->spec_name = 'Dvd';
    }

    public function __destruct()
    {
        $this->sku = null;
        $this->name = null;
        $this->price = null;
        $this->spec_name = null;
        $this->size = null;
    }

    public function setSpecs($data)
    {
        $this->size = $data->size;
    }

    public function prepareSaveQuery() 
    {
        $query = "INSERT INTO $this->spectablename SET product_id = $this->id, ";
        $fieldlist = array('size');
    
        return array($query,$fieldlist);
    }

    public function prepareGetQuery()
    {
        $query = '(SELECT '.$this->tablename.'.id, '.$this->tablename.'.sku, '.$this->tablename.'.name, '.$this->tablename.'.price, '.$this->tablename.'.spec_name, '.$this->spectablename.'.size FROM '.$this->tablename.' JOIN '.$this->spectablename.' ON '.$this->tablename.'.id = '.$this->spectablename.'.product_id ORDER BY id)'; 

        $fieldlist = array('id', 'sku', 'name', 'price', 'spec_name', 'size');
        
        return array($query, $fieldlist);
    }
}
