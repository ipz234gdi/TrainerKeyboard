<?php
namespace App\Core;

abstract class BaseController {
  protected function view(string $view, array $data=[]): void {
    extract($data);
    $viewFile = __DIR__ . '/../Views/' . $view . '.php';
    require __DIR__ . '/../Views/layouts/main.php';
  }
  protected function redirect(string $to): void {
    header("Location: {$to}");
    exit;
  }
}
