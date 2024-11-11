<?php

namespace App\Models\Classes;
use App\Models\Product;

class Dvd extends Product
{
    private float $size;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->size = isset($data['size'])? (float)$data['size']:0.0;
    }

    public function getType(): string
    {
        return 'Dvd';
    }

    public function getAttributesString(): string
    {
        return "Size: " . $this->size . " MB";
    }
    public static function getSpecificFields(): array
    {
        return [
            'size' => 'Size (MB)',
        ];
    }
    protected function validateSpecificFields(): array
    {
        $errors = [];

        if ($this->size <= 0) {
            $errors[] = "Size must be a positive integer.";
        }

        return $errors;
    }

}
