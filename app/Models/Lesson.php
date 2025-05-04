<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Lesson {
  private PDO $db;
  public function __construct(){ $this->db=Database::getInstance(); }

  public function all(): array {
    return $this->db
      ->query("SELECT * FROM lessons ORDER BY id")
      ->fetchAll();
  }

  public function getById(int $id): array {
    $stmt = $this->db->prepare("SELECT * FROM lessons WHERE id=?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function getByOrder(int $offset): array {
    $stmt = $this->db->prepare("SELECT * FROM lessons ORDER BY id LIMIT 1 OFFSET ?");
    $stmt->execute([$offset]);
    return $stmt->fetch();
  }
}
