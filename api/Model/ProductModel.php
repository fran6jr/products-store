<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
class ProductModel extends Database
{
    public function getProducts($limit)
    {
        return $this->select("SELECT * FROM products LIMIT ?;", ["i", $limit]);
    }

    public function addProduct($product)
    {
        $sku = $product->sku;
        $name = $product->name;
        $price = $product->price;
        $size = $product->size ? $product->size : "";
        $weight = $product->weight ? $product->weight : "";
        $height = $product->height ? $product->height : "";
        $width = $product->width ? $product->width : "";
        $length = $product->length ? $product->length : "";


        $sql;
        $params = [];
        $error;

        $sql = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $params = ["s", $sku];
        $result = $this->select($sql, $params);
        $count = $result[0]["COUNT(*)"];
        
        if (preg_match('/[^A-Za-z0-9]/', $sku || $name || $size || $weight || $height || $width || $length))
            $error = 'Invalid data format';
        else if($count > 0)
            $error = "Product exists";
        else if (!$price || !$name || !$sku)
            $error = "Missing required fields";
        else if ($weight && $size)
            $error = "Product cannot have both weight and size";
        else if ($weight && ($height || $width || $length))
            $error = "Product cannot have weight and dimensions";
        else if ($size && ($height || $width || $length))
            $error = "Product cannot have size and dimensions";
        else if (($size || $weight) && ($height || $width || $length))
            $error = "Product must be of a type";
        else if (($height || $width || $length) && !($height && $width && $length))
            $error = "Product must have all dimensions";
        else if (!$weight && !$size && !$height && !$width && !$length)
            $error = "Product must have weight, size, or dimensions";
        if (($price < 0) || ($weight && $weight < 0) || ($size && $size < 0) || ($height && $height < 0) || ($width && $width < 0) || ($length && $length < 0))
            $error = "Invalid data - Input of type number must be positive";
        else if ($sku == "")
            $error = "Product SKU cannot be empty";
        else if ($name == "")
            $error = "Product name cannot be empty";


        if ($error != "")
            throw new Error($error);
        
        if ($weight) {
            $sql = "INSERT INTO products (sku, name, price, weight) VALUES (?, ?, ?, ?);";
            $params = ["ssdi", $sku, $name, $price, $weight];
        }
        else if ($size) {
            $sql = "INSERT INTO products (sku, name, price, size) VALUES (?, ?, ?, ?);";
            $params = ["ssdi", $sku, $name, $price, $size];
        }
        else {
            $sql = "INSERT INTO products (sku, name, price, height, width, length) VALUES (?, ?, ?, ?, ?, ?);";
            $params = ["ssdddd", $sku, $name, $price, $height, $width, $length];
        }

        return $this->createRemove($sql, $params);

    }

    public function removeProducts($skus = [])
    { 
        if (count($skus) == 0)
            throw new Error('No Products Selected');
        foreach ($skus as $sku) {
            if (preg_match('/[^A-Za-z0-9]/', $sku))
            throw new Error('Invalid data format');
        }

        foreach ($skus as $sku) {
            $sql = "DELETE FROM products WHERE sku = ?";
            $params = ["s", $sku];
            $this->createRemove($sql, $params);
        }

        return true;
    }
    
}