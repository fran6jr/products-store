<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class Book extends ProductModel
{    
    private $weight;

    public function __construct($product) {
        parent::__construct();
        $this->sku = isset($product->sku) ? $product->sku : '';
        $this->type = 'Book';
        $this->name = isset($product->name) ? $product->name : '';
        $this->price = isset($product->price) ? $product->price : null;
        $this->weight = isset($product->weight) ? $product->weight : null;
    }

    protected function validate()
    {
        $error = parent::validate();
        if ($error != false)
            return $error;

        if (!isset($this->weight))
            return "Product must have weight!";
        
        return false;
    }

    public function getProducts() {

        $sql = "SELECT p.sku, p.name, p.price, p.type, b.weight FROM products p INNER JOIN book b ON b.sku = p.sku WHERE p.type = 'Book';";
        return $this->select($sql);
    }

    public function setProduct() {
        
        $error = $this->validate();
        if ($error != false)
            throw new Exception($error);

        $sql = "INSERT INTO book (sku, weight) VALUES (?, ?);";
        $param = ["ss", $this->sku, $this->weight];

        $this->save($sql, $param);
    }
}