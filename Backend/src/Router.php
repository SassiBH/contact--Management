<?php
namespace App;

class Router
{
    private $routes = [];

    public function get($route, $handler)
    {
        $this->addRoute('GET', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->addRoute('POST', $route, $handler);
    }

    public function put($route, $handler)
    {
        $this->addRoute('PUT', $route, $handler);
    }

    public function delete($route, $handler)
    {
        $this->addRoute('DELETE', $route, $handler);
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query strings
    
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove full match
                $handler = $route['handler'];
    
                $requestData = [];
                if (in_array($method, ['POST', 'PUT'])) {
                    $rawInput = file_get_contents('php://input');
                    error_log("Raw input: " . $rawInput); // Log raw input
                    $requestData = json_decode($rawInput, true) ?? [];
                    error_log("Parsed input: " . json_encode($requestData)); // Log parsed data
                }
    
                if (is_array($handler)) {
                    $controller = new $handler[0]();
                    $method = $handler[1];
    
                    if (method_exists($controller, $method)) {
                        call_user_func_array([$controller, $method], array_merge($matches, [$requestData]));
                        return;
                    }
                }
    
                http_response_code(500);
                echo json_encode(['error' => 'Handler is invalid or not callable.']);
                return;
            }
        }
    
        http_response_code(404);
        echo json_encode(['error' => 'Route not found.']);
    }
    

    private function addRoute($method, $route, $handler)
    {
        // Replace ":parameter" with regex capture group
        $pattern = '/^' . preg_replace('/:\w+/', '([^\/]+)', str_replace('/', '\/', $route)) . '$/';
        $this->routes[] = ['method' => $method, 'pattern' => $pattern, 'handler' => $handler];
    }
}
