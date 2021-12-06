<?php 
//namespace model\Product;

class Product
{
    protected $tablename = 'products';
    protected $fieldlist = array('sku','name','price', 'spec_name');

    protected $id;
    protected $sku;
    protected $name;
    protected $price;    
    protected $spec_name;
    protected $specs;

    public function __construct() 
    {
        $this->id = null;
    }

    public function setData($data) 
    {
        $this->sku = $data->sku;
        $this->name = $data->name;
        $this->price = $data->price;
        $this->spec_name = $data->spec_name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function prepareSaveQuery() 
    {
        $query = "INSERT INTO $this->tablename SET ";
        $fieldlist = array('sku','name', 'price', 'spec_name');

        return array($query,$fieldlist);
    }
    
    public function prepareSelectWhereQuery($wherefield)
    {
        $query = 'SELECT * FROM ' . $this->tablename . ' WHERE '. $wherefield .' = :'. $wherefield .';';

        return $query;
    }
    
    public function prepareDeleteOneQuery()
    {
        $query = 'DELETE FROM ' . $this->tablename . ' WHERE id = '.$this->id.';';

        return $query;
    }
}