<?php

namespace App\Models\Classes;
use App\Models\Product;

class Furniture extends Product
{
    private float $weight;
    private float $length;
    private float $height;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->weight = isset($data['width'])? (float)$data['width']:0.0;
        $this->length = isset($data['length'])? (float)$data['length']:0.0;
        $this->height = isset($data['height'])? (float)$data['height']:0.0;
    }

    public function getType(): string
    {
        return 'Furniture';
    }

    public function getAttributesString(): string
    {
        return "Width: " . $this->weight . ", Length: " . $this->length . ", Height: " . $this->height;
    }
    public static function getSpecificFields(): array
    {
        return [
            'width' => 'width (cm)',
            'length' => 'Length (cm)',
            'height' => 'Height (cm)',
        ];
    }
    protected function validateSpecificFields(): array {
        $errors = [];

        if ($this->weight <= 0) {
            $errors[] = "Width must be a positive number.";
        }

        if ($this->length <= 0) {
            $errors[] = "Length must be a positive number.";
        }

        if ($this->height <= 0) {
            $errors[] = "Height must be a positive number.";
        }

        return $errors;
    }



}
