<?php

namespace App\Middlewares;

/**
 * Middleware to check if the user is logged in.
 */
class AuthMiddleware
{
  /**
   * Handle the middleware.
   *
   * If the user is not logged in, redirects them to the login page.
   *
   * @return void
   */
  public function handle()
  {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
      header('Location: /login');
      exit;
    }
  }
}
