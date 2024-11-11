<?php

namespace App\Models;

use PDO;
use App\Models\Classes\DB\DataBase;

//use App\Controllers\HeaderController; 
// Used in deleteItems(), for redirecting

use Exception;
class ProductList
{
    // Class dedicated for Product List or the "Default" page when entering
    private $db;
    private $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database;
        $this->db = $database->getConnection();
    }

    // Fetch all products
    public function getAllProducts()
    {
        $stmt = $this->db->prepare('SELECT * FROM products');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single product by its ID
    public function getProductById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function itemsToDelete(array $items)
    {
        if (empty($items)) {
            throw new Exception('No items selected for deletion.');
        }
        $placeholders = implode(',', array_fill(0, count($items), '?'));
        $stmt = $this->db->prepare("DELETE FROM products WHERE sku IN ($placeholders)");
        if (!$stmt->execute($items)) {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : 'Unknown error';
            throw new Exception("Failed to delete items. SQL Error: " . $errorMessage);
        } else {
            // header('Location: ' . HeaderController::getDefaultFullPath());
        }
    }
}
