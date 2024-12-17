<?php
namespace App\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;

class AuthController
{
    public function login($data)
{
  
    
    $user = User::findByUsername($data['username']);
    if ($user) {
        error_log("User found: " . json_encode($user)); // Debugging log
    } else {
        error_log("User not found for username: " . $data['username']); // Debugging log
    }

    if ($user && password_verify($data['password'], $user['password'])) {
        $token = JWT::encode(
            [
                'iss' => $_ENV['JWT_ISSUER'],
                'iat' => time(),
                'exp' => time() + 3600,
                'sub' => $user['id']
            ],
            $_ENV['JWT_SECRET'],
            'HS256'
        );
        echo json_encode(['token' => $token]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
    }
}

public function register($data)
{
    if ((!isset($data['username']) || !isset($data['password']))||($data['username']===''|| !$data['password']==='')) {
        http_response_code(400);
        echo json_encode(['error' => 'Username and password are required.']);
        return;
    }
    if(User::findByUsername($data['username'])){
        http_response_code(401);
        echo json_encode(['error' => 'Username already used.']);
        return;
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password
    $result = User::create([
        'username' => $data['username'],
        'password' => $hashedPassword, // Store hashed password
    ]);

    if ($result) {
        echo json_encode(['message' => 'User registered successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Unable to register user']);
    }
}

public function logout()
    {
        
        header('Authorization:'); // Clear the Authorization header
        echo json_encode(['message' => 'Logged out successfully']);
    }



}
