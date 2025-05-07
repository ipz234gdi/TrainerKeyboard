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

  // Метод для отримання завершених уроків для користувача
  public function completedLessons(int $userId): array
  {
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

  // Метод для отримання статистики по конкретному уроку
  public function forLesson(int $lessonId): array
  {
    $stmt = $this->db->prepare(
      "SELECT * FROM lesson_stats WHERE lesson_id = :lesson_id"
    );
    $stmt->execute([':lesson_id' => $lessonId]);
    return $stmt->fetchAll();
  }

  // Метод для отримання статистики по користувачеві
  public function forUser(int $userId): array
  {
    $stmt = $this->db->prepare(
      "SELECT s.*, l.title AS lesson_title, l.difficulty, l.rating
         FROM stats s
         JOIN lessons l ON s.lesson_id = l.id
         WHERE s.user_id = :user_id"
    );
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll();
  }

  // Додавання методу для обчислення середніх статистик
  public function getAverageStats(int $userId): array
  {
    $stmt = $this->db->prepare(
      "SELECT AVG(wpm) AS avg_wpm, AVG(accuracy) AS avg_accuracy
         FROM stats
         WHERE user_id = :user_id"
    );
    $stmt->execute([':user_id' => $userId]);

    // Логування результату запиту
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Логування в консоль
    // echo "<script>console.log('SQL Query executed for user_id: $userId. Result: " . json_encode($result) . "');</script>";


    if ($result['avg_wpm'] === null || $result['avg_accuracy'] === null) {
      // echo "<script>console.log('No stats found for user_id: $userId.');</script>";
      return ['average_wpm' => 0, 'average_accuracy' => 0];
    }

    return $result;
  }


  // Метод для отримання статистики по всіх користувачах
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
