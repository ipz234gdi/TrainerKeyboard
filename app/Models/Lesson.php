<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Lesson
{
  private PDO $db;
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function allByLangAndFilters(string $lang, string $difficulty, float $minRating): array
  {
    // Формуємо частину WHERE умови для мови та складності
    $whereClauses = [];
    $params = ['minRating' => $minRating];

    // Додаємо фільтрацію по мові, якщо вона не "усі"
    if ($lang !== 'all') {
      $whereClauses[] = 'l.lang = :lang';
      $params['lang'] = $lang;
    }

    // Додаємо фільтрацію по складності, якщо вона не "усі"
    if ($difficulty !== 'all') {
      $whereClauses[] = 'l.difficulty = :difficulty';
      $params['difficulty'] = $difficulty;
    }

    // Додаємо фільтрацію по рейтингу
    $whereClauses[] = 'l.rating >= :minRating';

    // Створюємо умову WHERE на основі наявних фільтрів
    $where = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

    // Формуємо SQL-запит
    $stmt = $this->db->prepare(
      "SELECT l.*, c.name AS category
        FROM lessons l
        LEFT JOIN categories c ON l.category_id = c.id
        $where
        ORDER BY l.rating DESC"
    );

    // Виконання запиту
    $stmt->execute($params);
    return $stmt->fetchAll();
  }


  public function all(): array
  {
    return $this->db
      ->query("SELECT l.*, c.name AS category FROM lessons l LEFT JOIN categories c ON l.category_id = c.id ORDER BY l.id")
      ->fetchAll();
  }

  public function getById(int $id): ?array
  {
    $stmt = $this->db->prepare(
      "SELECT l.*, c.name AS category
       FROM lessons l
       LEFT JOIN categories c ON l.category_id=c.id
       WHERE l.id=?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
  }

  public function getLangById(int $id): ?string
  {
    // Підготовка запиту для отримання мови
    $stmt = $this->db->prepare(
      "SELECT lang FROM lessons WHERE id = ?"
    );
    $stmt->execute([$id]);

    // Повертаємо результат, якщо мова знайдена
    $lang = $stmt->fetchColumn();

    return $lang ?: null; // якщо мови немає, повертаємо null
  }

  public function create(array $data): bool
  {
    $stmt = $this->db->prepare(
      "INSERT INTO lessons(title, content, lang, category_id, tags)
       VALUES(:title, :content, :lang, :cat, :tags)"
    );
    return $stmt->execute([
      ':title' => $data['title'],
      ':content' => $data['content'],
      ':lang' => $data['lang'],
      ':cat' => $data['category_id'] ?: null,
      ':tags' => $data['tags'] ?? ''
    ]);
  }

  public function update(array $data): bool
  {
    $stmt = $this->db->prepare(
      "UPDATE lessons
         SET title=:title, content=:content, lang=:lang, category_id=:cat, tags=:tags, difficulty=:difficulty, rating=:rating
         WHERE id=:id"
    );
    return $stmt->execute([
      ':title' => $data['title'],
      ':content' => $data['content'],
      ':lang' => $data['lang'],
      ':cat' => $data['category_id'] ?: null,
      ':tags' => $data['tags'] ?? '',
      ':difficulty' => $data['difficulty'],
      ':rating' => $data['rating'],
      ':id' => $data['id']
    ]);
  }

  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare("DELETE FROM lessons WHERE id=?");
    return $stmt->execute([$id]);
  }

  public function search(string $q, string $lang, string $difficulty, float $minRating): array
  {
    // Формуємо SQL-запит
    $sql = "SELECT id, title, LEFT(content, 200) AS preview, lang
            FROM lessons
            WHERE lang = :lang
              AND (title LIKE :q OR content LIKE :q)
              AND difficulty = :difficulty
              AND rating >= :minRating
            ORDER BY rating DESC";

    // Перевірка: виведемо значення, які передаються в запит
    // echo "SQL Query: $sql<br>";
    // echo "Params: lang=$lang, q=$q, difficulty=$difficulty, minRating=$minRating<br>";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':lang' => $lang,
      ':q' => "%{$q}%",
      ':difficulty' => $difficulty,
      ':minRating' => $minRating
    ]);

    // Перевіримо, скільки записів повертається
    $results = $stmt->fetchAll();
    // echo "Results count: " . count($results) . "<br>"; // Додано для перевірки

    return $results;
  }

  public function updateLessonRating(int $lessonId): void
  {
    // Отримуємо всі статистики для конкретного уроку
    $stmt = $this->db->prepare(
      "SELECT wpm FROM stats WHERE lesson_id = :lesson_id"
    );
    $stmt->execute([':lesson_id' => $lessonId]);
    $wpmValues = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Якщо є статистика для цього уроку
    if (count($wpmValues) > 0) {
      // Обчислюємо середнє значення wpm для цього уроку
      $averageLessonWpm = array_sum($wpmValues) / count($wpmValues);

      // Отримуємо середнє значення wpm для всіх уроків
      $stmt = $this->db->prepare(
        "SELECT AVG(wpm) AS average_wpm FROM stats"
      );
      $stmt->execute();
      $overallAverageWpm = $stmt->fetchColumn();

      // Якщо середнє значення для всіх уроків не є нульовим
      if ($overallAverageWpm > 0) {
        // Обчислюємо відсоток від середнього
        $percentage = (10 - ($averageLessonWpm / $overallAverageWpm)) * 1;

        // Оновлюємо рейтинг уроку в таблиці lessons
        $stmt = $this->db->prepare(
          "UPDATE lessons SET rating = :rating WHERE id = :lesson_id"
        );
        $stmt->execute([
          ':rating' => round($percentage, 2), // Оновлюємо рейтинг як відсоток
          ':lesson_id' => $lessonId
        ]);
      }
    }
  }

  public function updateLessonDifficulty(int $lessonId): void
  {
    // Отримуємо всі WPM (швидкість друку) для цього уроку з таблиці stats
    $stmt = $this->db->prepare(
      "SELECT wpm FROM stats WHERE lesson_id = :lesson_id"
    );
    $stmt->execute([':lesson_id' => $lessonId]);

    $wpms = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($wpms) > 0) {
      // Обчислюємо середній WPM
      $averageWpm = array_sum($wpms) / count($wpms);

      // Визначаємо відповідну складність (оскільки складність зберігається як ENUM)
      if ($averageWpm <= 20) {
        $difficulty = 'easy';
      } elseif ($averageWpm <= 40) {
        $difficulty = 'medium';
      } else {
        $difficulty = 'hard';
      }

      // Оновлюємо складність уроку в таблиці lessons
      $stmt = $this->db->prepare(
        "UPDATE lessons SET difficulty = :difficulty WHERE id = :lesson_id"
      );
      $stmt->execute([
        ':difficulty' => $difficulty,
        ':lesson_id' => $lessonId
      ]);
    }
  }
}
