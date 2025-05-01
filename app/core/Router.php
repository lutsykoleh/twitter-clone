<?php
namespace Core;

class Router
{
    protected $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        if (isset($this->routes[$method][$uri])) {
            [$controller, $method] = $this->routes[$method][$uri];
            $controllerInstance = new $controller();
            $controllerInstance->$method();
        } else {
            http_response_code(404);
            $title = '404 - Page Not Found';
            $content = __DIR__ . '/../views/errors/404.php';
            include __DIR__ . '/../views/layouts/main.php';
        }
    }

    public function run(): void
    {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    $this->dispatch($method, $uri);
    }
}
