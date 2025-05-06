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

  public function create(array $data): bool
  {
    $stmt = $this->db->prepare(
      "INSERT INTO lessons(title, content, category_id, tags)
       VALUES(:title, :content, :cat, :tags)"
    );
    return $stmt->execute([
      ':title' => $data['title'],
      ':content' => $data['content'],
      ':cat' => $data['category_id'] ?: null,
      ':tags' => $data['tags'] ?? ''
    ]);
  }

  public function update(int $id, array $data): bool
  {
    $stmt = $this->db->prepare(
      "UPDATE lessons
       SET title=:title, content=:content, category_id=:cat, tags=:tags
       WHERE id=:id"
    );
    return $stmt->execute([
      ':title' => $data['title'],
      ':content' => $data['content'],
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

  public function search(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        if (session_status()===PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error'=>'Unauthorized']);
            return;
        }

        $q    = trim($_GET['query'] ?? '');
        $lang = $_SESSION['lang'] ?? 'ua';
        $lessons = $q !== ''
            ? (new Lesson())->search($q, $lang)
            : [];

        echo json_encode($lessons);
    }
}
