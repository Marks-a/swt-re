<?php 
// Database need work:
// -New username and other credentials so would other not see or use.
// -Change class location to a secure folder.(No Inject and other attack be availble)
namespace App\Models\Classes\DB;


use PDO;
use PDOException;
class DataBase {
  
    private $host = 'localhost';
    private $db_name = 'product';
    private $username = 'root';
    private $charset = 'utf8mb4';
    private $password = '';
    private $connection;


    public function __construct()
    {
        // Initialize the connection
        $this->connect();
    }

    // Connect to the database using PDO
    public function connect()
    {
        // If connection is already established, return it
        if ($this->connection !== null) {
            return $this->connection;
        }

        // Build the DSN (Data Source Name) string
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

        // PDO options for error handling and fetching style
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true // Persistent connection for better performance
        ];

        try {
            // Establish a new PDO connection
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // Handle connection errors
            echo 'Database Connection Error: ' . $e->getMessage();
            exit; // Stop script if connection fails
        }

        return $this->connection;
    }

    // Get the current database connection
    public function getConnection()
    {
        return $this->connect();
    }

}
?>