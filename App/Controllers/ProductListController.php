<?php

namespace App\Controllers;

use PDO;
use Exception;
use App\Models\ProductList;
use App\Controllers\HeaderController; // Used in deleteItems(), for redirecting
use App\Models\DeleteModel;

class ProductListController
{
    private $productModel;

    public function __construct(ProductList $productModel)
    {
        $this->productModel = $productModel;
    }

    // Display all products
    public function index()
    {
        $products = $this->productModel->getAllProducts();
        require_once '../Views/Body/ProductList.php';
    }

    // Display a single product based on its ID
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        require_once '../Views/Body/ProductList.php';
    }

    public function requestHandle($postItems)
    {
        $items= $postItems['items'];
        $this->productModel->itemsToDelete($items);
    }



}