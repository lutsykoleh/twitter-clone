<?php

use App\Controllers\UserController;

return function ($router) {

  // User routes
  $router->get('register', [UserController::class, 'register']);
  $router->post('register', [UserController::class, 'register']);
  $router->get('login', [UserController::class, 'login']);
  $router->post('login', [UserController::class, 'login']);
  $router->get('logout', [UserController::class, 'logout']);
};
