<?php
require_once PROJECT_ROOT_PATH . "/Repo/BaseRepository";
require_once PROJECT_ROOT_PATH . "/Model/ProductModel/Book.php";
 
abstract class BookRepository extends BaseRepository
{
    public function create(Book $book) {
      $error = $book->validate();
      if ($error != false)
        throw new Exception($error);

      $this->params = ["ssss", $book->getSku(), $book->getWeight()];
      $productParams = ["ss", $this->sku, $this->weight];
      
      $sql = "INSERT INTO book (sku, weight) VALUES (?, ?);";

      try {
        $stmt = $this->executeStatement( $query , $params);              
        $stmt->close();
      } catch(Exception $e) {
        throw New Exception( $e->getMessage() );
      }
    }

    public function getById($sku) {}

    public function getAll() {}

    public function delete($skus = []) {}
}
