<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
abstract class ProductModel extends Database
{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    abstract public function getProducts();
    abstract public function setProduct();
    
    protected function validate() {
        if (!isset($this->sku))
            return "Product SKU cannot be empty";
        else if (!isset($this->name) || ($this->price < 0))
            return "Product name cannot be empty and must be a positive number";
        else if (!isset($this->price) || !isset($this->name) || !isset($this->sku))
            return "Missing required fields";
        return false;
    }

    protected function save($sql = '', $params2 = []) {
        
      $params = [["ssss", $this->sku, $this->name, $this->price, $this->type], $params2];
      $sqls = ["INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?);", $sql];

      foreach($sqls as $index => $sql)
        $this->create($sql, $params[$index]);
    }

    public function deleteProducts($skus = []) {

        $sql = "DELETE FROM products WHERE sku = ?";
        foreach($skus as $sku)
        {
            $params = ["s", $sku];
            $this->delete($sql, $params);
        }
    }
}
