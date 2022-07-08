<?php

require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

class ProductController extends BaseController
{
    public $mappedClasses = array();

    public function __construct()
    {
        $this->mappedClasses = array(
            'Book' => Book,
            'Furniture' => Furniture,
            'DVD' => DVD
        );   
    }

    public function list()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) != 'GET') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        try {
            $arrProducts = [];
            foreach($this->mappedClasses as $key => $product) {
                require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $product .".php";
                $ProductModel = new $product();
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
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) != 'POST') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        try {
            $product = json_decode(file_get_contents("php://input"));

            $productType = $this->mappedClasses[$product->type];
            require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $productType .".php";
            $ProductModel = new $productType();
            
            $arrProducts = $ProductModel->setProduct($product);
            echo "After arr Product  .";
            $responseData = json_encode($arrProducts);
            $this->ok($responseData);
        } catch (Error $e) {
            $this->serverError(json_encode(array('error' => 'Something went wrong!')));
        }
    
    }

    public function delete() {
        
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        if (strtoupper($requestMethod) != 'DELETE') {
            $this->notFound(json_encode(array('error' => 'Method not supported')));
            return;
        }

        $products = json_decode(file_get_contents("php://input"));
        
        $sortedProducts = [];

        foreach ($this->mappedClasses as $key => $ProductModel)
        {
            array_push($sortedProducts, array_filter($products, "$ProductModel::filter"));
        }

        try {
            foreach($sortedProducts as $sorted) 
            {
                $type = $sorted[0]->type;
                $skus = array_column($products, 'sku');
                require_once PROJECT_ROOT_PATH . "/"."Model/ProductModel/". $type .".php";
                $ProductModel = new $this->mappedClasses[$type]();
                $ProductModel->delete($skus);
            }

            $responseData = json_encode($arrProducts);
            $this->ok($responseData);
        } catch (Error $e) {
            $this->serverError(json_encode(array('error' => 'Something went wrong!')));
        }

    }
    
}