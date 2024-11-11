<?php

use App\Models\Classes\DB\DataBase; // Needed for one of the controllers

use App\Controllers\HeaderController;
use App\Controllers\ProductListController;
use App\Models\ProductList;
use App\Controllers\AddProductController; // Controller for Add product page

// Used for header(), when redirecting in the models
ob_start(); 

require_once '../../vendor/autoload.php';
require_once '../Views/Base/Base.php'; // To load the base for css

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// DB initialization & Product Model initialization for Product List page
$database = new Database();
$productModel = new ProductList($database);

$action = $_GET['action'] ?? 'default';
if (!isset($_GET['action'])) {
    header("Location: /App/Src/index.php?action=default");
    exit;
}


$header = new HeaderController();
switch ($action) {
    case 'default':
        $header->main_ProductPage();
        $header->showHeader();

        $controller = new ProductListController($productModel);
        $controller->index();

        // Here should be controller initilizing for Delete POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->requestHandle($_POST);
        }

        break;
    case 'Add_Product':
        $header->add_ProductPage();
        $header->showHeader();

        $formController = new AddProductController($database->getConnection());
        $formController->show();

        // Here should be controller initilizing for Add POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formController->requestHandle($_POST);
        }

        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Page Not Found";
        break;
}

ob_end_flush();
















// header and body initialization part
// $header = new HeaderController();
// $header->showHeader(null);

// Controller for product list
// $controller = new ProductListController($productModel);
// $controller->index();

// Controller for Add product
// $formController = new AddProductController();
// $formController->show();
