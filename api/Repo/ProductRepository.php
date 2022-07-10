<?php
require_once PROJECT_ROOT_PATH . "/Repo/BaseRepository";
require_once PROJECT_ROOT_PATH . "/Model/ProductModel/ProductModel.php";
 
abstract class BookRepository extends BaseRepository
{
    public function create(ProductModel $product) {
      $error = $book->validate();
      if ($error != false)
        throw new Exception($error);

      $this->params = ["ssss", $book->getSku(), $book->getName(), $book->getPrice(), "book"];
      $productParams = ["ss", $this->sku, $this->weight];
      
      $sql = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?);";

      try {
        $stmt = $this->executeStatement($sql , $params);              
        $stmt->close();
      } catch(Exception $e) {
        throw New Exception( $e->getMessage() );
      }
    }

    public function getById($sku) {}

    public function getAll() {

    }

    public function delete($skus = []) {
      foreach ($skus as $sku) {
        $sql = "DELETE FROM products WHERE sku = ?";
        $params = ["s", $sku];
        $this->select($sql, $params, true);

        try {
          $stmt = $this->executeStatement( $query , $params);              
          $stmt->close();
        } catch(Exception $e) {
          throw New Exception( $e->getMessage() );
        }
      }
    }
}
