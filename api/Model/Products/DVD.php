<?php
require_once PROJECT_ROOT_PATH . "/Model/Product.abstract.php";


class Dvd extends Product
{
    public function insert_Product($product)
    {
        $this->set_productData($product);
        
        $this->validate();

        $sql = "INSERT INTO products (sku, name, price, size) VALUES (?, ?, ?, ?);";
        $params = ["ssdi", $this->sku, $this->name, $this->price, $this->size];

        return $this->createRemove($sql, $params);
    }

    public function validate()
    {
        $this->check();

        if (!isset($this->size))
            $thiserror = "Product must have size!";

        $this->check_error();
    }
}