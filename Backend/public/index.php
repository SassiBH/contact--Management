<?php

$allowedOrigins = ['http://localhost:8080', 'http://localhost:8100','https://contact-management-ffn7c6igg-sassibhs-projects.vercel.app','*'];
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}


require_once __DIR__ . '/../vendor/autoload.php';
use App\Router;
use Dotenv\Dotenv;

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}

$router = new Router();

//the router list for our api http request calls
$router->post('/login', ['App\\Controllers\\AuthController', 'login']);
$router->post('/register', ['App\\Controllers\\AuthController', 'register']);
$router->post('/logout', ['App\\Controllers\\AuthController', 'logout']);

$router->get('/contacts', ['App\\Controllers\\ContactController', 'index']);
$router->post('/contacts', ['App\\Controllers\\ContactController', 'store']);
$router->put('/contacts/:id', ['App\\Controllers\\ContactController', 'update']);
$router->delete('/contacts/:id', ['App\\Controllers\\ContactController', 'destroy']);
$router->get('/contacts/search', ['App\\Controllers\\ContactController', 'search']);

$router->run();
