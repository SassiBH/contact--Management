<?php
namespace App;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4',
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );

            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}
