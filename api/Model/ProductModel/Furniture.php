<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class Furniture extends ProductModel
{
    private $height;
    private $width;
    private $length;

    protected function validate()
    {
        $this->check();

        if (!isset($this->height) || !isset($this->width) || !isset($this->length))
            $this->error = "Product must have all dimensions";

        $this->check_error();
    }
    
    public function getProducts()
    {
        $sql = "SELECT p.sku, p.name, p.price, p.type, f.height, f.width, f.length FROM products p INNER JOIN furniture f ON f.sku = p.sku WHERE p.type = 'Furniture';";
        return $this->select($sql);
    }

    public static function filter($var)
    {
        return($var->type == 'Furniture');
    }
    
    public function setProduct($product)
    {
        $this->sku = $product->sku;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->type = $product->type;
        $this->height = $product->height;
        $this->width = $product->width;
        $this->length = $product->length;
        $this->params = ["iiii", $this->sku, $this->name, $this->price, $this->type];
        $productParams = ["iiii", $this->sku, $this->height, $this->width, $this->length];
        
        $sql = "INSERT INTO furniture (sku, height, width, length) VALUES (?, ?, ?, ?);";

        $this->validate();
        return $this->preSelect($sql, $productParams);
    }

    public function delete($skus = [])
    { 
        foreach ($skus as $sku) {
            $sql = "DELETE FROM products, furniture WHERE sku = ?";
            $params = ["s", $sku];
            $this->select($sql, $params, true);
        }

        return true;
    }
}