<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Stats {
  private PDO $db;
  public function __construct(){ $this->db = Database::getInstance(); }

  public function create(int $uid,int $lid,int $wpm,float $acc): bool {
    $s = $this->db->prepare(
      "INSERT INTO stats(user_id,lesson_id,wpm,accuracy) VALUES(?,?,?,?)"
    );
    return $s->execute([$uid,$lid,$wpm,$acc]);
  }

  public function forUser(int $uid): array {
    $s = $this->db->prepare(
      "SELECT s.*, l.title FROM stats s
       JOIN lessons l ON l.id=s.lesson_id
       WHERE s.user_id=?
       ORDER BY s.created_at DESC"
    );
    $s->execute([$uid]);
    return $s->fetchAll();
  }

  public function allUsersStats(): array {
    // останній результат кожного користувача
    $s = $this->db->query(
      "SELECT u.username, l.title, s.wpm, s.accuracy, s.created_at
       FROM stats s
       JOIN users u ON u.id = s.user_id
       JOIN lessons l ON l.id = s.lesson_id
       ORDER BY s.created_at DESC"
    );
    return $s->fetchAll();
  }
}
