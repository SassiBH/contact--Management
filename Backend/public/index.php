<?php



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

$router->get('/contacts', ['App\\Controllers\\ContactController', 'index']);
$router->post('/contacts', ['App\\Controllers\\ContactController', 'store']);
$router->put('/contacts/:id', ['App\\Controllers\\ContactController', 'update']);
$router->delete('/contacts/:id', ['App\\Controllers\\ContactController', 'destroy']);
$router->get('/contacts/search', ['App\\Controllers\\ContactController', 'search']);

$router->run();
