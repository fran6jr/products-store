<?php
require_once PROJECT_ROOT_PATH . "/Model/Products.php";
 
class ProductModel extends Database
{
    public function get_Products($limit)
    {
        return $this->select("SELECT * FROM products LIMIT ?;", ["i", $limit]);
    }

    private function set_Book($product)
    {
        $book = new Book();
        
        return $book->insert_Product($product);
    }

    private function set_Dvd($product)
    {
        $dvd = new Dvd();
        
        return $dvd->insert_Product($product);
    }

    private function set_Furniture($product)
    {
        $furniture = new Furniture();
        
        return $furniture->insert_Product($product);
    }

    public function set_Product($data)
    {        
        $productType = $data->productType;
        $product = $data->product;

        $setProductType = 'set_' . setucfirst((strtolower($uri[3])));

        return $this->{$setProductType}($product);

    }

    public function remove_Products($skus = [])
    { 
        if (count($skus) == 0)
            throw new Exception('No Products Selected');
        foreach ($skus as $sku) {
            if (preg_match('/[^A-Za-z0-9]/', $sku))
            throw new Exception('Invalid data format');
        }

        foreach ($skus as $sku) {
            $sql = "DELETE FROM products WHERE sku = ?";
            $params = ["s", $sku];
            $this->createRemove($sql, $params);
        }

        return true;
    }
}
    
