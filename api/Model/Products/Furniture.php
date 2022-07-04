<?php
require_once PROJECT_ROOT_PATH . "/Model/Product.abstract.php";


class Furniture extends Product
{
    public function insert_Product($product)
    {
        $this->set_productData($product);
        
        $this->validate();
        
        $sql = "INSERT INTO products (sku, name, price, height, width, length) VALUES (?, ?, ?, ?, ?, ?);";
        $params = ["ssdddd", $sku, $name, $price, $height, $width, $length];

        return $this->createRemove($sql, $params);
    }

    public function validate()
    {
        $this->check();

        if (!isset($this->height) || !isset($this->width) || !isset($this->length))
            $this->error = "Product must have all dimensions";

        $this->check_error();
    }
}