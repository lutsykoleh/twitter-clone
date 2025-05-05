<?php

namespace App\Middlewares;

/**
 * Middleware to check if the user is not logged in.
 */
class GuestMiddleware
{
  /**
   * Handles the guest middleware
   *
   * This middleware redirects logged-in users to the homepage.
   *
   * @return void
   */
  public function handle()
  {
    // If the user is logged in, redirect them to the homepage
    if (isset($_SESSION['user_id'])) {
      header('Location: /');
      exit;
    }
  }
}
