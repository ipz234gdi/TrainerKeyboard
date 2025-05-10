<?php
namespace App\Core;
use PDO;
use PDOException;

class Database
{
  private static ?PDO $instance = null;
  private function __construct()
  {
  }
  public static function getInstance(): PDO
  {
    if (!self::$instance) {
      $env = $_ENV;
      $dsn = "{$env['DB_DRIVER']}:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_DATABASE']};charset=utf8";
      try {
        self::$instance = new PDO($dsn, $env['DB_USERNAME'], $env['DB_PASSWORD'], [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
      } catch (PDOException $e) {
        die('DB connection failed: ' . $e->getMessage());
      }
    }
    return self::$instance;
  }
}
