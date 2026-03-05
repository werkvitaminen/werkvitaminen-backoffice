<?php
namespace App\Core;

class Router
{
    private $routes = [];
    private $publicRoutes = ['/login', '/logout'];

    public function get($path, $callback) {
        $this->routes['GET'][] = ['path' => $path, 'callback' => $callback];
    }

    public function post($path, $callback) {
        $this->routes['POST'][] = ['path' => $path, 'callback' => $callback];
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = $this->routes[$method] ?? [];

        if (!in_array($uri, $this->publicRoutes)) {
            if (empty($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }
        }

        foreach ($routes as $route) {
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([0-9]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($route['callback'], $matches);
            }
        }

        http_response_code(404);
        echo "<h1>404 Pagina niet gevonden</h1>";
    }
}