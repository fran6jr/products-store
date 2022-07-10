<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
 
abstract class BaseRepository extends Database
{
    public $table_name;

    public function __construct($table)
    {
      $this->table_name = $table;
    }
    
    abstract public function create($product);

    abstract public function getById($sku);

    abstract public function getAll();

    abstract public function delete($skus = []);
}
