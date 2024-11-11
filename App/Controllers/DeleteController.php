<?php
require '../../vendor/autoload.php';

use App\Models\DeleteModel;
use App\Models\Classes\DB\DataBase;
use App\Controllers\HeaderController;

$database = new DataBase();
$deleteModel = new DeleteModel($database);

// Check if the POST request contains the 'items' array
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['items'])) {
    $items = $_POST['items'];
    try {
        $deleteModel->deleteItems($items);
        header('Location: '.HeaderController::getDefaultFullPath());
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No items selected for deletion.";
}
