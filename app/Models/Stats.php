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

  // Новий метод: підрахунок кількості унікальних завершених уроків
  public function countCompletedLessons(int $userId): int
  {
    $stmt = $this->db->prepare(
      "SELECT COUNT(DISTINCT lesson_id) as count
       FROM stats
       WHERE user_id = :uid"
    );
    $stmt->execute([':uid' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['count'] : 0;
  }

  // Метод створення запису статистики з валідацією вхідних параметрів
  public function create(int $uid, int $lid, int $wpm, float $acc): bool
  {
    if ($wpm < 0 || $acc < 0 || $acc > 100) {
      // Невірні вхідні дані — повертаємо false
      return false;
    }

    $s = $this->db->prepare(
      "INSERT INTO stats(user_id, lesson_id, wpm, accuracy) VALUES(?, ?, ?, ?)"
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Додавання методу для обчислення середніх статистик
  public function getAverageStats(int $userId): array
  {
    $stmt = $this->db->prepare(
      "SELECT AVG(wpm) AS average_wpm, AVG(accuracy) AS average_accuracy
         FROM stats
         WHERE user_id = :user_id"
    );
    $stmt->execute([':user_id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['average_wpm'] === null || $result['average_accuracy'] === null) {
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
    return $s->fetchAll(PDO::FETCH_ASSOC);
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
