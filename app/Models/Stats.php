<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Stats
{
  private PDO $db;
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function completedLessons(int $userId): array {
    $stmt = $this->db->prepare(
      "SELECT DISTINCT lesson_id
       FROM stats
       WHERE user_id = :uid"
    );
    $stmt->execute([':uid' => $userId]);
    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'lesson_id');
  }

  public function create(int $uid, int $lid, int $wpm, float $acc): bool
  {
    $s = $this->db->prepare(
      "INSERT INTO stats(user_id,lesson_id,wpm,accuracy) VALUES(?,?,?,?)"
    );
    return $s->execute([$uid, $lid, $wpm, $acc]);
  }

  public function forUser(int $uid): array
  {
    $s = $this->db->prepare(
      "SELECT s.*, l.title FROM stats s
       JOIN lessons l ON l.id=s.lesson_id
       WHERE s.user_id=?
       ORDER BY s.created_at DESC"
    );
    $s->execute([$uid]);
    return $s->fetchAll();
  }

  public function allUsersStats(): array
  {
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

  public function getAverageStats(int $uid): array
    {
        $s = $this->db->prepare(
            "SELECT AVG(wpm) as average_wpm, AVG(accuracy) as average_accuracy
             FROM stats 
             WHERE user_id = ?"
        );
        $s->execute([$uid]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

  public function forUserFiltered(int $uid, ?string $from, ?string $to, int $lessonId): array
  {
    $sql = "SELECT s.*, l.title 
            FROM stats s
            JOIN lessons l ON l.id=s.lesson_id
            WHERE s.user_id = :uid";
    $params = [':uid' => $uid];

    if ($lessonId) {
      $sql .= " AND s.lesson_id = :lid";
      $params[':lid'] = $lessonId;
    }
    if ($from) {
      $sql .= " AND s.created_at >= :from";
      $params[':from'] = $from . ' 00:00:00';
    }
    if ($to) {
      $sql .= " AND s.created_at <= :to";
      $params[':to'] = $to . ' 23:59:59';
    }
    $sql .= " ORDER BY s.created_at ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }

  public function allUsersStatsFiltered(?string $from, ?string $to, int $lessonId): array
  {
    $sql = "SELECT u.username, l.title, s.wpm, s.accuracy, s.created_at
            FROM stats s
            JOIN users u   ON u.id = s.user_id
            JOIN lessons l ON l.id = s.lesson_id
            WHERE 1=1";
    $params = [];

    if ($lessonId) {
      $sql .= " AND s.lesson_id = :lid";
      $params[':lid'] = $lessonId;
    }
    if ($from) {
      $sql .= " AND s.created_at >= :from";
      $params[':from'] = $from . ' 00:00:00';
    }
    if ($to) {
      $sql .= " AND s.created_at <= :to";
      $params[':to'] = $to . ' 23:59:59';
    }
    $sql .= " ORDER BY s.created_at DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }
}
