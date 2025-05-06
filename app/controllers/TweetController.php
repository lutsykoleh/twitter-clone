<?php

namespace App\Controllers;

use App\Models\Tweet;
use Core\Validator;

/**
 * Handles all the logic related to tweets.
 */
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

  /**
   * Displays a tweet by its ID.
   *
   * @param int $id The ID of the tweet
   */
  public function show($id)
  {
    $tweetModel = new Tweet();
    $tweet = $tweetModel->getById((int)$id);

    if (!$tweet) {
      header('Location: /');
      exit;
    }

    $title = 'Tweet Details';
    $content = __DIR__ . '/../views/pages/tweets/show.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Displays the edit form for a tweet by its ID.
   *
   * @param int $id The ID of the tweet
   */
  public function edit($id)
  {
    $tweetModel = new Tweet();
    $tweet = $tweetModel->getById((int)$id);

    if (!$tweet || $tweet['user_id'] !== ($_SESSION['user_id'] ?? 0)) {
      header('Location: /your-tweets');
      exit;
    }

    $title = 'Edit Tweet';
    $content = __DIR__ . '/../views/pages/tweets/edit.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Handles the POST request to update a tweet.
   *
   * @param int $id The ID of the tweet
   */
  public function update($id)
  {
    $tweetModel = new Tweet();
    $tweet = $tweetModel->getById((int)$id);

    if (!$tweet || $tweet['user_id'] !== ($_SESSION['user_id'] ?? 0)) {
      header('Location: /your-tweets');
      exit;
    }

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
        if ($tweetModel->update((int)$id, $_POST['content'])) {
          header('Location: /your-tweets');
          exit;
        } else {
          $formErrors['general'] = 'Failed to update tweet.';
        }
      } else {
        $errors = $validator->getErrors();
      }
    }

    $title = 'Edit Tweet';
    $content = __DIR__ . '/../views/pages/tweets/edit.php';
    include __DIR__ . '/../views/layouts/main.php';
  }

  /**
   * Deletes a tweet by its ID.
   *
   * @param int $id The ID of the tweet
   */
  public function delete($id)
  {
    $tweetModel = new Tweet();
    $tweet = $tweetModel->getById((int)$id);

    if (!$tweet || $tweet['user_id'] !== ($_SESSION['user_id'] ?? 0)) {
      header('Location: /your-tweets');
      exit;
    }

    if ($tweetModel->delete((int)$id)) {
      header('Location: /');
      exit;
    } else {
      $error = "Failed to delete tweet.";
      $tweets = $tweetModel->getUserTweets($_SESSION['user_id']);
      $title = 'Your Tweets';
      $content = __DIR__ . '/../views/pages/tweets/your-tweets.php';
      include __DIR__ . '/../views/layouts/main.php';
    }
  }
}
