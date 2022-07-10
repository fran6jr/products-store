<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class DVD extends ProductModel
{
    private $size;

    public function __construct($product) {
        parent::__construct();
        $this->sku = isset($product->sku) ? $product->sku : '';
        $this->type = 'DVD';
        $this->name = isset($product->name) ? $product->name : '';
        $this->price = isset($product->price) ? $product->price : null;
        $this->size = isset($product->size) ? $product->size : null;
    }

    protected function validate()
    {
        $error = parent::validate();
        if ($error != false)
            return $error;

        if (!isset($this->size))
            $this->error = "Product must have size!";

        return false;
    }
    
    public function getProducts() {

        $sql = "SELECT p.sku, p.name, p.price, p.type, d.size FROM products p INNER JOIN dvd d ON d.sku = p.sku WHERE p.type = 'DVD';";
        return $this->select($sql);
    }

    public function setProduct() {

        $error = $this->validate();
        if ($error != false)
            throw new Exception($error);

        $sql = "INSERT INTO dvd (sku, size) VALUES (?, ?);";
        $param = ["ss", $this->sku, $this->size];
        
        $this->save($sql, $param);
    }
}