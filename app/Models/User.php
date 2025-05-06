<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class User
{
  private PDO $db;
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function exists(string $u): bool
  {
    $s = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username=?");
    $s->execute([$u]);
    return $s->fetchColumn() > 0;
  }

  public function create(string $u, string $h): bool
  {
    $s = $this->db->prepare("INSERT INTO users(username,password) VALUES(?,?)");
    return $s->execute([$u, $h]);
  }

  public function find(string $u): ?array
  {
    $s = $this->db->prepare("SELECT id,username,password FROM users WHERE username=?");
    $s->execute([$u]);
    return $s->fetch() ?: null;
  }

  public function findById(int $id): ?array
  {
    $s = $this->db->prepare(
      "SELECT id, username, password, role
       FROM users WHERE id = ?"
    );
    $s->execute([$id]);
    return $s->fetch() ?: null;
  }

  public function isAdmin(int $id): bool
  {
    $user = $this->findById($id);
    return $user && $user['role'] === 'administrator';
  }

}
