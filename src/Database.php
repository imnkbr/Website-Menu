<?php
namespace Src;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $db_name = 'menus';
    private $username = 'root';
    private $password = '0440858232';
    public $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die('Database Connection Error: ' . $exception->getMessage());
        }

        return $this->conn;
    }
}
