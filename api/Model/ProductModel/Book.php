<?php
require_once PROJECT_ROOT_PATH . "/Model/ProductModel.php";

class Book extends ProductModel
{    
    private $weight;

    protected function validate()
    {
        $this->check();

        if (!isset($this->weight))
        $this->error = "Product must have weight!";

        $this->check_error();
    }
    
    public function getProducts()
    {
        $sql = "SELECT b.sku, products.name, products.price, b.weight FROM products INNER JOIN book b ON products.sku = b.sku WHERE product.type = 'book';";
        return $this->select($sql);
    }

    public static function filter($var)
    {
        return($var->type == 'Book');
    }

    public function setProduct($product)
    {        
        $this->$sku = $product->sku;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->weight = $product->weight;
        $filler = "i";
        $this->params = [$filler, $this->sku, $this->name, $this->price];
        $productParams = [$filler, $this->sku, $this->weight];
        
        $sql = "INSERT INTO book (sku, weight) VALUES (?, ?);";

        $this->validate();

        return $this->preSelect($sql, $productParams);
    }

    public function delete($skus = [])
    { 
        foreach ($skus as $sku) {
            $sql = "DELETE FROM products, book WHERE sku = ?";
            $params = ["s", $sku];
            $this->select($sql, $params, true);
        }

        return true;
    }
}