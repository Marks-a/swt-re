<?php

namespace App\Models;
use PDO;
// This class is dedicated for Add product page/form.


use App\Controllers\HeaderController;


abstract class Product
{
    protected PDO $pdo;
    protected string $sku;
    protected string $name;
    protected float $price;


    // Constructor to initialize common properties
    public function __construct(array $data)
    {
        $this->sku = $data['sku'];
        $this->name = $data['name'];
        $this->price = isset($data['price']) ? (float) $data['price'] : 0.0;
    }


    // Method to return common fields as array
    public static function getCommonFields(): array
    {
        return [
        'sku' => ['label' => 'SKU', 'type' => 'text'],
        'name' => ['label' => 'Name', 'type' => 'text'],
        'price' => ['label' => 'Price', 'type' => 'number'],
        ];
    }

    // Abstract method for each subclass to implement its own type and attributes format
    abstract public function getType(): string;
    abstract public function getAttributesString(): string;
    abstract public static function getSpecificFields(): array;

    public function validate(): array
    {
        $errors = [];

        if (empty($this->sku)) {
            $errors[] = "SKU is required.";
        }

        if (empty($this->name)) {
            $errors[] = "Name is required.";
        }

        if ($this->price <= 0) {
            $errors[] = "Price must be a positive number.";
        }

        // Call specific field validations from subclass
        $specificErrors = $this->validateSpecificFields();
        return array_merge($errors, $specificErrors);
    }

    // Abstract method for validating specific fields, to be implemented by subclasses
    abstract protected function validateSpecificFields(): array;

    public function save($pdo): void
    {
        $this->pdo = $pdo;
        // Validate before saving
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new \Exception(implode(", ", $errors));
        }
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO products (sku, name, price, type, attribute) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $this->sku,
                $this->name,
                $this->price,
                $this->getType(),
                $this->getAttributesString()
            ]);
            header('Location: ' . HeaderController::getDefaultFullPath());
            exit();
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                // throw new \Exception("Duplicate SKU");
                echo '<div class="error-message">Duplicate SKU</div>';
            } else {
                // throw new \Exception("Database error: " . $e->getMessage());
                echo '<div class="error-message">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
    }

}


