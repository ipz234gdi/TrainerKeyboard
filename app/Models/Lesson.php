<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Lesson {
  private PDO $db;
  public function __construct(){ $this->db=Database::getInstance(); }
  public function all(): array {
    $s=$this->db->query("SELECT * FROM lessons");
    return $s->fetchAll();
  }
}
