<?php

namespace App\Models;

use Core\Database;

class Tweet
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  /**
   * Creates a new tweet for a user.
   *
   * @param int $userId The ID of the user
   * @param string $content The content of the tweet
   * @return bool True if the tweet was created successfully, false otherwise
   */
  public function create(int $userId, string $content): bool
  {
    $sql = "INSERT INTO tweets (user_id, content) VALUES (:user_id, :content)";
    try {
      $this->db->query($sql, [
        'user_id' => $userId,
        'content' => $content
      ]);
      return true;
    } catch (\PDOException $e) {
      error_log("Error creating tweet: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Retrieves all tweets with usernames.
   *
   * @return array An array of tweets
   */
  public function getAll(): array
  {
    $sql = "SELECT t.id, t.user_id, t.content, t.created_at, u.username 
                FROM tweets t 
                JOIN users u ON t.user_id = u.id 
                ORDER BY t.created_at DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  /**
   * Retrieves tweets for a specific user.
   *
   * @param int $userId The ID of the user
   * @return array An array of the user's tweets
   */
  public function getUserTweets(int $userId): array
  {
    $sql = "SELECT t.id, t.user_id, t.content, t.created_at, u.username 
                FROM tweets t 
                JOIN users u ON t.user_id = u.id 
                WHERE t.user_id = :user_id 
                ORDER BY t.created_at DESC";
    $stmt = $this->db->query($sql, ['user_id' => $userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
