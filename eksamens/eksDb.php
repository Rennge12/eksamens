<?php 
class Db
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $host = 'localhost';
        $dbname = 'guestbook';
        $user = 'root';
        $password = '';

        try {
            $this->conn = new PDO("sqlite:$dbname");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}