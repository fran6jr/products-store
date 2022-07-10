<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class Furniture extends ProductModel
{
    private $height;
    private $width;
    private $length;

    public function __construct($product) {
        parent::__construct();
        $this->sku = isset($product->sku) ? $product->sku : '';
        $this->type = 'Furniture';
        $this->name = isset($product->name) ? $product->name : '';
        $this->price = isset($product->price) ? $product->price : null;
        $this->height = isset($product->height) ? $product->height : null;
        $this->width = isset($product->width) ? $product->width : null;
        $this->length = isset($product->length) ? $product->length : null;
        
    }

    protected function validate()
    {
        $error = parent::validate();
        if ($error != false)
            return $error;

        if (!isset($this->height) || !isset($this->width) || !isset($this->length))
            $this->error = "Product must have all dimensions";

        return false;
    }
    
    public function getProducts() {

        $sql = "SELECT p.sku, p.name, p.price, p.type, f.height, f.width, f.length FROM products p INNER JOIN furniture f ON f.sku = p.sku WHERE p.type = 'Furniture';";
        return $this->select($sql);
    }
    
    public function setProduct() {

        $error = $this->validate();
        if ($error != false)
            throw new Exception($error);

        $sql = "INSERT INTO furniture (sku, height, width, length) VALUES (?, ?, ?, ?);";
        $param = ["ssss", $this->sku, $this->height, $this->width, $this->length];

        return $this->save($sql, $param);
    }
}