<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";


class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    protected function validate()
    {
        $this->check();

        if (!isset($product->height) || !isset($product->width) || !isset($product->length))
            $this->error = "Product must have all dimensions";

        $this->check_error();
    }
    
    public function getProducts()//work on this
    {
        $sql = "SELECT f.sku, products.name, products.price, f.height, f.width, f.length FROM products INNER JOIN furniture f ON products.sku = f.sku WHERE product.type = 'Furniture';";
        return $this->select($sql);
    }

    public static function filter($var)
    {
        return($var->type == 'Furniture');
    }
    
    public function setProduct($product)
    {
        $this->$sku = $product->sku;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->height = $product->height;
        $this->width = $product->width;
        $this->length = $product->length;
        $filler = "i";
        $this->params = [$filler, $this->sku, $this->name, $this->price];
        $productParams = [$filler, $this->sku, $this->height, $this->width, $this->length];
        
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