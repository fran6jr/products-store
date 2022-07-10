<?php

require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

class ProductController extends BaseController
{
    public $mappedClasses = array();

    public function __construct()
    {
        $this->mappedClasses = array(
            'Book' => 'Book',
            'DVD' => 'DVD',
            'Furniture' => 'Furniture'
        );   
    }

    public function list()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) != 'GET') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        try {
            $arrProducts = [];
            foreach($this->mappedClasses as $key => $product) {
                require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $product .".php";
                $ProductModel = new $product('');
                $result = $ProductModel->getProducts();
                $merge = array_merge($arrProducts, $result);
                $arrProducts = $merge;
            }
            $responseData = json_encode($arrProducts);
            $this->ok($responseData);
        } catch (Error $e) {
            $this->serverError(json_encode(array('error' => 'Something went wrong!')));
        }
        
    }

    public function add() {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) != 'POST') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        try {
            $product = json_decode(file_get_contents("php://input"));

            $productType = $this->mappedClasses[$product->type];
            require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $productType .".php";
            $productModel = new $productType($product);
            $productModel->setProduct();
            $this->ok('');
        } catch (Error $e) {
            $this->serverError(json_encode(array('error' => 'Something went wrong!')));
        }
    
    }

    public function delete() {
        
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        if (strtoupper($requestMethod) != 'DELETE') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        $products = json_decode(file_get_contents("php://input"));
        
        $sortedProducts = [];

        foreach ($this->mappedClasses as $productType)
        {
            $arr = array_filter(
                    $products, 
                    function ($product) use ($productType) {
                        return $product->type == $productType;
                    }
                );
            $sortedProducts[] = array_values($arr);
        }

        $sortedProducts = array_values(array_filter(
            $sortedProducts,
            function ($sorted) {
                return count($sorted) > 0;
            }
        ));

        try {
            foreach($sortedProducts as $key => $sorted) 
            {
                $type = $sorted[$key]->type;
                $skus = array_column($sorted, 'sku');
                require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $type .".php";
                $ProductModel = new $this->mappedClasses[$type]($type);
                $ProductModel->deleteProducts($skus);
            }
            $this->ok('');
        } catch (Error $e) {
            $this->serverError(json_encode(array('error' => 'Something went wrong!')));
        }

    }
    
}