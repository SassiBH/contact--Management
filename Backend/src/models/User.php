<?php
namespace App\Models;

use App\Database;

class User
{
    public static function create($data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        return $stmt->execute([
            ':username' => $data['username'], // Already sanitized in AuthController
            ':password' => $data['password']  // Already hashed in AuthController
        ]);
    }
    public static function findByUsername($username)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        return $stmt->fetch();
    }
}
