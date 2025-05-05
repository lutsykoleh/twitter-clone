<?php

namespace Core;

/**
 * Class Router
 *
 * This class handles the routing functionality of the application,
 * managing route definitions and dispatching requests to the appropriate
 * handlers.
 */
class Router
{
  /**
   * @var array $routes Stores all the registered routes.
   */
  protected $routes = [];

  /**
   * Registers a GET route.
   *
   * @param string $path The path for the route.
   * @param callable|array $handler The handler for the route.
   * @param array $middlewares The middlewares for the route.
   * @return void
   */
  public function get(string $path, $handler, array $middlewares = []): void
  {
    $this->routes['GET'][trim($path, '/')] = [
      'handler' => $handler,
      'middlewares' => $middlewares
    ];
  }

  /**
   * Registers a POST route.
   *
   * @param string $path The path for the route.
   * @param callable|array $handler The handler for the route.
   * @param array $middlewares The middlewares for the route.
   * @return void
   */
  public function post(string $path, $handler, array $middlewares = []): void
  {
    $this->routes['POST'][trim($path, '/')] = [
      'handler' => $handler,
      'middlewares' => $middlewares
    ];
  }

  /**
   * Dispatches the request to the appropriate route handler.
   *
   * @param string $method The HTTP method of the request.
   * @param string $uri The URI of the request.
   * @return void
   */
  public function dispatch(string $method, string $uri): void
  {
    $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

    if (isset($this->routes[$method][$uri])) {
      $route = $this->routes[$method][$uri];
      $handler = $route['handler'];
      $middlewares = $route['middlewares'];

      // Execute middlewares
      foreach ($middlewares as $middleware) {
        $middlewareInstance = new $middleware();
        $middlewareInstance->handle();
      }

      // Call the handler
      if (is_array($handler)) {
        [$controller, $method] = $handler;
        $controllerInstance = new $controller();
        $controllerInstance->$method();
      } else {

        call_user_func($handler);
      }
    } else {
      // Return 404 if route not found
      http_response_code(404);
      $title = '404 - Page Not Found';
      $content = __DIR__ . '/../views/errors/404.php';
      include __DIR__ . '/../views/layouts/main.php';
    }
  }

  /**
   * Runs the router, dispatching the current request.
   *
   * @return void
   */
  public function run(): void
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    $this->dispatch($method, $uri);
  }
}
