<?php
namespace App;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            if (isset($_ENV['CONNECT']) && $_ENV['CONNECT'] === 'true') {
                // Connect using the environment variables (as usual)
                self::$connection = new PDO(
                    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4',
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS']
                );
            } else {
                // Connect to the default database using the hardcoded credentials
                self::$connection = new PDO(
                    'mysql:host=mysql-176b02df-contat-manager49-044f.f.aivencloud.com;port=25083;dbname=defaultdb;charset=utf8mb4',
                    'avnadmin',
                    'AVNS_OQZ0O1Ux8Ix86ssbiN9'
                );
            }

            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}
