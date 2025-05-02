<?php

use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

return function ($router) {
  // Guest routes (for unauthorized users only)
  $router->get('register', [UserController::class, 'register'], [GuestMiddleware::class]);
  $router->post('register', [UserController::class, 'register'], [GuestMiddleware::class]);
  $router->get('login', [UserController::class, 'login'], [GuestMiddleware::class]);
  $router->post('login', [UserController::class, 'login'], [GuestMiddleware::class]);

  // Protected routes (for authorized users only)
  $router->get('logout', [UserController::class, 'logout'], [AuthMiddleware::class]);


  $router->get('', function () {
    $title = 'Home';
    $content = __DIR__ . '/../views/pages/home.php';
    include __DIR__ . '/../views/layouts/main.php';
  });
};
