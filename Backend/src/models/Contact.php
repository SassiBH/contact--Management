<?php
namespace App\Models;

use App\Database;

class Contact
{
  

    public static function create($data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO contacts (user_id, first_name, last_name,age, email, phone, country) VALUES (:user_id, :first_name, :last_name, :age, :email, :phone, :country)');
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':first_name' => htmlspecialchars($data['first_name']),
            ':last_name' => htmlspecialchars($data['last_name']),
            ':age' => htmlspecialchars($data['age']),
            ':email' => htmlspecialchars($data['email']),
            ':phone' => htmlspecialchars($data['phone']),
            ':country' => htmlspecialchars($data['country'])
        ]);
    }

    public static function find($userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM contacts WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function update($id, $data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE contacts SET first_name = :first_name, last_name = :last_name, age = :age, email = :email, phone = :phone, country = :country WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':first_name' => htmlspecialchars($data['first_name']),
            ':last_name' => htmlspecialchars($data['last_name']),
            ':age' => htmlspecialchars($data['age']),
            ':email' => htmlspecialchars($data['email']),
            ':phone' => htmlspecialchars($data['phone']),
            ':country' => htmlspecialchars($data['country'])
        ]);
    }

    public static function delete($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM contacts WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public static function search($query, $userId)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT * FROM contacts WHERE user_id = :user_id AND (first_name LIKE :query OR last_name LIKE :query OR age LIKE :query OR email LIKE :query OR country LIKE :query OR phone LIKE :query)'
        );
        $stmt->execute([
            ':user_id' => $userId,
            ':query' => '%' . $query . '%'
        ]);
        return $stmt->fetchAll();
    }
    

}
