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
   * This method takes the HTTP method and the URI of the request, and
   * uses them to find the appropriate route handler. The handler is then
   * called with the parameters extracted from the URI.
   *
   * @param string $method The HTTP method of the request.
   * @param string $uri The URI of the request.
   * @return void
   */
  public function dispatch(string $method, string $uri): void
  {
    $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
    $params = [];

    // Loop through all the registered routes for the given method.
    foreach ($this->routes[$method] ?? [] as $routePath => $route) {
      $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([a-zA-Z0-9_]+)', $routePath);
      $pattern = "#^$pattern$#";

      if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);
        $params = $matches;

        $handler = $route['handler'];
        $middlewares = $route['middlewares'];

        // Call any middlewares before calling the handler.
        foreach ($middlewares as $middleware) {
          $middlewareInstance = new $middleware();
          $middlewareInstance->handle();
        }

        if (is_array($handler)) {
          [$controller, $method] = $handler;
          $controllerInstance = new $controller();
          call_user_func_array([$controllerInstance, $method], $params);
        } else {
          call_user_func_array($handler, $params);
        }
        return;
      }
    }

    // If no route matches the request, then return a 404 error.
    http_response_code(404);
    $title = '404 - Page Not Found';
    $content = __DIR__ . '/../views/errors/404.php';
    include __DIR__ . '/../views/layouts/main.php';
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
