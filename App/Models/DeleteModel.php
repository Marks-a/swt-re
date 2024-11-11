<?php
namespace App\Models;
use App\Models\Classes\DB\DataBase;
use PDO;
use Exception;
class DeleteModel
{
    private PDO $pdo;

    public function __construct(DataBase $database)
    {
        $this->pdo = $database->getConnection();
    }

    public function deleteItems(array $items): void
    {
        if (empty($items)) {
            throw new Exception('No items selected for deletion.');
        }

        // Debugging: Print the items to delete
        echo "Items to delete: " . implode(', ', $items) . "<br>";

        // Prepare a DELETE statement with placeholders
        $placeholders = implode(',', array_fill(0, count($items), '?'));
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE sku IN ($placeholders)");

        // Execute the statement and check for errors
        if (!$stmt->execute($items)) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Failed to delete items. SQL Error: " . $errorInfo[2]);
        } else {
            echo "Items deleted successfully!";
        }
    }
}