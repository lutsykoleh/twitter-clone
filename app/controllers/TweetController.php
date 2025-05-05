<?php

namespace App\Controllers;

use App\Models\Tweet;
use Core\Validator;

class TweetController
{
  /**
   * Displays the main page with a form to create a tweet and a list of all tweets.
   */
  public function index()
  {
    $tweetModel = new Tweet();
    $tweets = $tweetModel->getAll();

    // Initialize variables for the form
    $validator = new Validator();
    $formErrors = isset($formErrors) ? $formErrors : [];

    $title = 'Tweets';
    $content = __DIR__ . '/../views/pages/tweets/index.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Displays the page with only the user's tweets, without a form.
   */
  public function yourTweets()
  {
    $tweetModel = new Tweet();
    $tweets = [];

    if (isset($_SESSION['user_id'])) {
      $tweets = $tweetModel->getUserTweets($_SESSION['user_id']);
    }

    $title = 'Your Tweets';
    $content = __DIR__ . '/../views/pages/tweets/your-tweets.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Handles the POST request to create a tweet.
   */
  public function store()
  {
    $validator = new Validator();
    $errors = [];
    $formErrors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $rules = [
        'content' => [
          'required' => true,
          'min' => 5,
          'max' => 280
        ]
      ];

      $validator->validate($_POST, $rules);

      if (!$validator->hasErrors()) {
        $tweet = new Tweet();
        if ($tweet->create($_SESSION['user_id'], $_POST['content'])) {
          header('Location: /');
          exit;
        } else {
          $formErrors['general'] = 'Failed to create tweet.';
        }
      } else {
        $errors = $validator->getErrors();
      }
    }

    // In case of errors, return to the main page
    $tweetModel = new Tweet();
    $tweets = $tweetModel->getAll();
    $title = 'Tweets';
    $content = __DIR__ . '/../views/pages/tweets/index.php';
    include __DIR__ . '/../views/layouts/main.php';
  }
}
