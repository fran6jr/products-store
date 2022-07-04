<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

abstract class Product extends Database
{    
    public $product;

    public $error;
    
    abstract public function insert_Product();

    abstract public function validate();

    public function check_error()
    {
        if (isset($this->error))
            throw new Exception($this->error);
    }

    public function set_productData($product)
    {
        $this->product = $product;
    }

    public function check()
    {
        $sql = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $params = ["s", $sku];
        $result = $this->select($sql, $params);
        $count = $result[0]["COUNT(*)"];

        if($count > 0)
            $this->error = "Product exists";
        else if (!isset($this->sku))
            $this->error = "Product SKU cannot be empty";
        else if (!isset($this->name) || ($this->price < 0))
            $this->error = "Product name cannot be empty and must be a positive number";
        else if (!isset($this->price) || !isset($this->name) || !isset($this->sku))
            $this->error = "Missing required fields";

        $this->check_error();
    }
}
