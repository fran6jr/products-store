<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class DVD extends ProductModel
{
    private $size;

    protected function validate()
    {
        $this->check();

        if (!isset($this->size))
            $this->error = "Product must have size!";

        $this->check_error();
    }
    
    public function getProducts()//work on this
    {
        $sql = "SELECT p.sku, p.name, p.price, p.type, d.size FROM products p INNER JOIN dvd d ON d.sku = p.sku WHERE p.type = 'DVD';";
        return $this->select($sql);
    }
    
    public static function filter($var)
    {
        return($var->type == 'DVD');
    }

    public function setProduct($product)
    {
        $this->sku = $product->sku;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->type = $product->type;
        $this->size = $product->size;
        $this->params = ["ssss", $this->sku, $this->name, $this->price, $this->type];
        $productParams = ["ss", $this->sku, $this->size];
        
        $sql = "INSERT INTO dvd (sku, size) VALUES (?, ?);";

        $this->validate();
        return $this->preSelect($sql, $productParams);
    }

    public function delete($skus = [])
    { 
        foreach ($skus as $sku) {
            $sql = "DELETE FROM products, dvd WHERE sku = ?";
            $params = ["s", $sku];
            $this->select($sql, $params, true);
        }

        return true;
    }
}