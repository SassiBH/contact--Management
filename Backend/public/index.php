<?php

header("Access-Control-Allow-Origin: http://localhost:8100"); // Allow CORS 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}


require_once '../vendor/autoload.php';
use App\Router;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

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
