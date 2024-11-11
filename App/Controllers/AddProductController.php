<?php

namespace App\Controllers;

use PDO;
use App\Models\Product;
use App\Models\Classes\Book;
use App\Models\Classes\Dvd;
use App\Models\Classes\Furniture;


use Exception; // Used in requestHandle()

class AddProductController
{
    private PDO $pdo;
    private array $productTypes = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->loadProductTypes();
    }

    private function loadProductTypes()
    {
        $this->productTypes = [
            'Dvd' => DVD::class,
            'Furniture' => Furniture::class,
            'Book' => Book::class,
            // Add additional product types here if needed
        ];
    }
    public function getFormData(): array
    {
        $formData = [
            'types' => [],
            'commonFields' => Product::getCommonFields()
        ];

        foreach ($this->productTypes as $type => $class) {
            $formData['types'][$type] = [
                'label' => $type,
                'fields' => $class::getSpecificFields()
            ];
        }
        return $formData;
    }

    public function show()
    {
        $formData = $this->getFormData();
        require_once '../Views/Body/AddProduct.php';
    }

    public function createProduct(array $data)
    {
        if (!isset($this->productTypes[$data['type']])) {
            throw new \Exception("Invalid product type.");
        }
        $productClass = $this->productTypes[$data['type']];
        $product = new $productClass($data);
        $product->save($this->pdo);
    }

    public function requestHandle($data)
    {
        try {
            $this->createProduct($data);
            // header('Location: ' . HeaderController::getDefaultFullPath());
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

}