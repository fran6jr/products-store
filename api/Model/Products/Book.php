<?php
require_once PROJECT_ROOT_PATH . "/Model/Product.abstract.php";

class Book extends Product
{    
    public function insert_Product($product)
    {        
        $this->set_productData($product);
        
        $this->validate();
        
        $sql = "INSERT INTO products (sku, name, price, weight) VALUES (?, ?, ?, ?);";
        $params = ["ssdi", $this->sku, $this->name, $this->price, $this->weight];

        return $this->createRemove($sql, $params);
    }

    public function validate()
    {
        $this->check();

        if (!isset($this->weight))
            $thiserror = "Product must have weight!";

        $this->check_error();
    }
}