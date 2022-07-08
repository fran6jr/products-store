<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
abstract class ProductModel extends Database
{

    protected $sku;
    protected $name;
    protected $price;
    protected $error;
    protected $params = array();
    private $sql = "INSERT INTO products (sku, name, price) VALUES (?, ?, ?, ?);";
    
    abstract protected function validate();

    abstract public function setProduct($product);

    abstract public function getProducts();

    abstract public static function filter($var);

    abstract public function delete($skus = []);

    protected function check_error()
    {
        if (isset($this->error))
            throw new Exception($this->error);
    }

    protected function check()
    {
        $this->error = '';

        $sql = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $params = ["s", $sku];
        $result = $this->select($sql, $params);
        $count = $result[0]["COUNT(*)"];

        if($count > 0)
            $this->error = "Product exists";
        else if (!isset($this->sku))
            $this->error = "Product SKU cannot be empty";
        else if (!isset($this->name) || ($this->price < 0))
            $this->error = "Product name cannot be empty and must be a positive number";
        else if (!isset($this->price) || !isset($this->name) || !isset($this->sku))
            $this->error = "Missing required fields";

        $this->check_error();
    }

    private function preSelect($sql = '', $productParams = [])
    {
        $params = [$this->params, $productParams];
        $queries = [$this->sql, $sql];

        foreach ($queries as $index => $query)
        {
            $param = $params[$index];
            $this->select($query, $param, true);
        }

        return true;
    }
}
