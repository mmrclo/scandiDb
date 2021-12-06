<?php

include_once '../controls/Dataaccess.php';
include_once '../models/Product.php';
include_once '../models/Book.php';
include_once '../models/Dvd.php';
include_once '../models/Furniture.php';

class Storage 
{   
    protected $data;
    protected $product;
   
    public function __construct($datareq) 
    {
        $this->data = $datareq;
    }

    public function filterRequest() 
    {
        foreach ($this->data as &$value) {
            $value = trim($value);
            $value = htmlspecialchars(strip_tags($value));
        }
        unset($value);
    }

    public function badRequest() 
    {
        http_response_code(404);
        return json_encode(
            array(
            'message' => 'This may not be a possible operation', 
            'try' => 'GET || POST || DELETE'
            )
        );
    }
    
    public function selectAll() 
    {
        $table = new Table();
        $table->connectToDB();
        
        $typeProduct = array('Book', 'Dvd', 'Furniture');
        $result = array();

        foreach ($typeProduct as $element) {
            $product = new $element();
            list($query, $fieldlist) = $product->prepareGetQuery();
            $partial = $table->selectAll($query, $fieldlist);
            if($partial){
                $result = array_merge($result, $partial);
            }
            unset($product);   
        }
        return json_encode($result);

        die();
    }
    
    public function save($data)
    {
        $this->filterRequest();

        $table = new Table();
        $table->connectToDB();

        $savedp = false;
        $saveds = false;
        $typeProduct = $data->spec_name;
        
        $product = new Product();
        $product->setData($data);

        $field = 'sku';
        $selectQuery = $product->prepareSelectWhereQuery($field);
        $sku = $data->sku;
        if(!$table->selectRowFromDb($selectQuery, $field, $sku)){
            try {
                list($query,$fieldlist) = $product->prepareSaveQuery();
                $savedp = $table->setToDatabase($query,$fieldlist, $data);
                
                unset($product);
                $query = null;
                if($savedp) {
                    $id = $table->getLastInsertId();
                    
                    $product = new $typeProduct();
                    $product->setSpecs($data);
                    $product->setId($id);
                    
                    list($query,$fieldlist) = $product->prepareSaveQuery();
                    $saveds = $table->setToDatabase($query,$fieldlist, $data);

                    unset($product);
                    $query = null;
                    unset($table);

                    if($saveds){
                        http_response_code(201);
                        return array('message' => 'Product saved to db');
                    } else {
                        return array('message' => 'Something went wrong, could not save specs to this item on db' );
                    }
                } else {
                    return array('message' => 'Something went wrong, could not save this item to db' );
                }
                 
            } catch (PDOException $e) {
                $error = $e->getMessage();
                $this->badRequest();
            }
        }
    }
    
    public function delete($data)
    {
        $this->filterRequest();

        $table = new Table();
        $table->connectToDB();

        $product = new Product();
        $id = $data->id;
        $product->setId($id);

        $field = 'id';
        $selectQuery = $product->prepareSelectWhereQuery($field);

        $deleteQuery = $product->prepareDeleteOneQuery();
        
        if($table->selectRowFromDb($selectQuery, $field, $id)) {
            if($table->deleteRow($deleteQuery)) {
                return array('message' => 'Product deleted');
            }
        } else {
            return array('Error' => 'Could not find item to delete' );
        }
        die();
    }
}