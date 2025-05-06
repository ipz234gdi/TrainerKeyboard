<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Category
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(): array
    {
        return $this->db
            ->query("SELECT * FROM categories ORDER BY name")
            ->fetchAll();
    }

}
