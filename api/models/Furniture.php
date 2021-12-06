<?php
//namespace \model\Furniture;

include_once './models/Product.php';

//use \model\Product as Product;

class Furniture extends Product
{
    protected $spectablename = 'furnitures';
    protected $width;
    protected $height;
    protected $length;

    public function __construct() {
        $this->spec_name = 'Furniture';
    }

    public function __destruct()
    {
        $this->sku = null;
        $this->name = null;
        $this->price = null;
        $this->spec_name = null;
        $this->height = null;
        $this->width = null;
        $this->length = null;
    }

    public function setSpecs($data) 
    {
        $this->height = $data->height;
        $this->width = $data->width;
        $this->length = $data->length;
    }

    public function prepareSaveQuery() 
    {
        $query = "INSERT INTO $this->spectablename SET product_id = $this->id, ";
        $fieldlist = array('height', 'length', 'width');
    
        return array($query,$fieldlist);
    }

    public function prepareGetQuery() {
        $query = '(SELECT '.$this->tablename.'.id, '.$this->tablename.'.sku, '.$this->tablename.'.name, '.$this->tablename.'.price, '.$this->tablename.'.spec_name, CONCAT('.$this->spectablename.'.height, " x ", '.$this->spectablename.'.width, " x ", '.$this->spectablename.'.length) AS dimension FROM '.$this->tablename.' JOIN '.$this->spectablename.' ON '.$this->tablename.'.id = '.$this->spectablename.'.product_id ORDER BY id)';

        $fieldlist = array('id', 'sku', 'name', 'price', 'spec_name', 'dimension');

        return array($query, $fieldlist);
    }
}