<?php
namespace App\Core;

use PDO;
use PDOException;

class DataBase
{
    private static ?DataBase $database = null;
    private ?PDO $conn = null;

    private function __construct()
    {
    }

    public static function getInstance(): DataBase
    {
        if (self::$database === null) {
            self::$database = new DataBase();
        }
        return self::$database;
    }

    public function connect(): PDO
    {
        if ($this->conn === null) {
            try {
                $driver = $_ENV['DB_DRIVER'] ?? 'pgsql';
                $host = $_ENV['DB_HOST'];
                $port = $_ENV['DB_PORT'] ?? '5432';
                $dbname = $_ENV['DB_NAME']; // ← CHANGÉ ICI : getenv() → $_ENV
                $user = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASSWORD'];

                $dsn = "{$driver}:host={$host};port={$port};dbname=maxit";                
                $this->conn = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                error_log("Erreur de connexion : " . $e->getMessage());
                throw $e;
            }
        }
        return $this->conn;
    }

    // Méthode pour créer une connexion sans spécifier de base de données (pour la création de DB)
    public function connectWithoutDB(): PDO
    {
        try {
            $driver = $_ENV['DB_DRIVER'];
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            $dbname = $_ENV ['DB_NAME'];

            $dsn = "{$driver}:host={$host};port={$port};dbname={$dbname}";

            $conn = new PDO($dsn, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
        }
    }
}
