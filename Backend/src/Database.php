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
                $dsn = "pgsql:host=dpg-ctfiihl6l47c73b94gbg-a.oregon-postgres.render.com;dbname=contactmanagement_kuk6";
                $pdo = new PDO($dsn, "root", "qMe8OGGp7K35mdccCD4BffmEdyZHnmx2");
                self::$connection = $pdo;

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Display a meaningful error message
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}

