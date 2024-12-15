<?php
namespace App;

use PDO;
use PDOException;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            try {
                self::$connection = new PDO(
                    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4',
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS']
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Display a meaningful error message
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
