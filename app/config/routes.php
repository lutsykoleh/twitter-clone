<?php

use App\Controllers\UserController;
use App\Controllers\TweetController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

return function ($router) {
  $router->get('', [TweetController::class, 'index'], []);

  // Route for user's tweets
  $router->get('your-tweets', [TweetController::class, 'yourTweets'], [AuthMiddleware::class]);

  // Guest routes (for unauthorized users only)
  $router->get('register', [UserController::class, 'register'], [GuestMiddleware::class]);
  $router->post('register', [UserController::class, 'register'], [GuestMiddleware::class]);
  $router->get('login', [UserController::class, 'login'], [GuestMiddleware::class]);
  $router->post('login', [UserController::class, 'login'], [GuestMiddleware::class]);

  // Protected routes (for authorized users only)
  $router->post('tweets/create', [TweetController::class, 'store'], [AuthMiddleware::class]);
  $router->get('logout', [UserController::class, 'logout'], [AuthMiddleware::class]);
};
