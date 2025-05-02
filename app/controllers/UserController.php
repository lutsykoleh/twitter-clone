<?php

namespace App\Controllers;

use App\Models\User;
use Core\Validator;

/** 
 * Handles user authentication
 */
class UserController
{
  /**
   * Handles user registration.
   *
   * Validates user input and creates a new user if validation passes.
   * Redirects to the login page upon successful registration.
   */
  public function register()
  {
    $validator = new Validator();
    $formErrors = [];

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Define validation rules
      $rules = [
        'username' => [
          'required' => true,
          'min' => 5,
          'max' => 100,
          'unique' => 'users:username'
        ],
        'email' => [
          'required' => true,
          'email' => true,
          'max' => 100,
          'unique' => 'users:email'
        ],
        'password' => [
          'required' => true,
          'min' => 6,
        ],
      ];

      // Validate the input data
      $validator->validate($_POST, $rules);

      // Check if there are no validation errors
      if (!$validator->hasErrors()) {
        $user = new User();

        // Create a new user
        if ($user->create($_POST['username'], $_POST['email'], $_POST['password'])) {
          // Redirect to the login page
          header('Location: /login');
          exit;
        } else {
          // Display an error message
          $formErrors['general'] = 'Failed to create user';
        }
      }
    }

    // Render the register view
    $title = 'Register';
    $content = __DIR__ . '/../views/pages/register.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Handles user login.
   *
   * Validates user input and authenticates the user if validation passes.
   * Redirects to the home page upon successful login.
   */
  public function login()
  {
    $validator = new Validator();
    $formErrors = [];

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Define validation rules
      $rules = [
        'email' => [
          'required' => true,
          'email' => true,
        ],
        'password' => [
          'required' => true
        ],
      ];

      // Validate the input data
      $validator->validate($_POST, $rules);

      // Check if there are no validation errors
      if (!$validator->hasErrors()) {
        // Find the user by the given email
        $user = (new User())->findByEmail($_POST['email']);
        // Check if the user exists and the password matches
        if ($user && password_verify($_POST['password'], $user['password'])) {
          // Start a session and store the user id in the session
          session_start();
          $_SESSION['user_id'] = $user['id'];
          // Redirect to the home page
          header('Location: /');
          exit;
        } else {
          // Display an error message
          $formErrors['general'] = 'Invalid email or password';
        }
      }
    }

    // Render the login view
    $title = 'Login';
    $content = __DIR__ . '/../views/pages/login.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Handles user logout.
   *
   * Destroys the current session and redirects the user to the login page.
   */
  public function logout()
  {
    // Destroy the current session
    session_start();
    session_destroy();
    // Redirect to the login page
    header('Location: /login');
    exit;
  }
}
