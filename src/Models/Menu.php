<?php

namespace Src\Models;

use Src\Database;
use PDO;

class Menu
{
    private $conn;
    private $table = 'menu';

    public $id;
    public $name;
    public $url;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Create a menu item
    public function create()
    {
        $query = "INSERT INTO $this->table (name, url) VALUES (:name, :url)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':url', $this->url);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Get all menu items
    public function read()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
