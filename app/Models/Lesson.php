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

  public function allByLang(string $lang): array
  {
    $stmt = $this->db->prepare(
      "SELECT l.*, c.name AS category
       FROM lessons l
       LEFT JOIN categories c ON l.category_id=c.id
       WHERE l.lang = :lang
       ORDER BY l.id"
    );
    $stmt->execute([':lang' => $lang]);
    return $stmt->fetchAll();
  }

  public function all(): array
  {
    return $this->db
      ->query("SELECT l.*, c.name AS category
               FROM lessons l
               LEFT JOIN categories c ON l.category_id=c.id
               ORDER BY l.id")
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

  public function update(int $id, array $data): bool
  {
    $stmt = $this->db->prepare(
      "UPDATE lessons
       SET title=:title, content=:content, lang=:lang, category_id=:cat, tags=:tags
       WHERE id=:id"
    );
    return $stmt->execute([
      ':title' => $data['title'],
      ':content' => $data['content'],
      ':lang' => $data['lang'],
      ':cat' => $data['category_id'] ?: null,
      ':tags' => $data['tags'] ?? '',
      ':id' => $id
    ]);
  }

  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare("DELETE FROM lessons WHERE id=?");
    return $stmt->execute([$id]);
  }

  public function search(string $q, string $lang): array
  {
    $sql = "SELECT id, title, LEFT(content,200) AS preview, lang
            FROM lessons
            WHERE lang = :lang
              AND (title LIKE :q OR content LIKE :q)
            ORDER BY id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':lang' => $lang, ':q' => "%{$q}%"]);
    return $stmt->fetchAll();
  }
}
