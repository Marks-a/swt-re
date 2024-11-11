<?php

namespace App\Models\Classes;
use App\Models\Product;

class Book extends Product
{
    private float $weight;

    // Constructor for Book
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->weight = isset($data['weight']) ? (float)$data['weight']: 0.0;
    }

    public function getType(): string
    {
        return 'Book';
    }

    public function getAttributesString(): string
    {
        return "Weigth: " . $this->weight . " KG";
    }
    public static function getSpecificFields(): array
    {
        return [
            'weight' => 'Weight (KG)',
        ];
    }
    protected function validateSpecificFields(): array {
        $errors = [];

        if ($this->weight <= 0) {
            $errors[] = "Weight must be a positive integer.";
        }

        return $errors;
    }

}
