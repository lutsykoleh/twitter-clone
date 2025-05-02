<?php

namespace App\Models;

use Core\Database;
use PDOException;

/**
 * Class User
 * @package App\Models
 */
class User
{
  /**
   * @var Database
   */
  private $db;

  /**
   * User constructor.
   */
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  /**
   * Create a new user
   * @param string $username
   * @param string $email
   * @param string $password
   * @return bool
   */
  public function create(string $username, string $email, string $password): bool
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    try {
      $this->db->query($sql, [
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
      ]);
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  /**
   * Find a user by email
   * @param string $email
   * @return array|null
   */
  public function findByEmail(string $email): ?array
  {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->db->query($sql, ['email' => $email]);
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $user ?: null;
  }
}
