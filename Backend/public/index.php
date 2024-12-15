<?php


header("Access-Control-Allow-Origin: *");
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
//for testing prod

$host = $_ENV['DB_HOST']; // From environment variables in Render
$db = $_ENV['DB_NAME']; // From environment variables
$user = $_ENV['DB_USER']; // From environment variables
$pass = $_ENV['DB_PASS']; // From environment variables

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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
