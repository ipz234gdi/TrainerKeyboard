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

  protected function ensureAdmin(): void {
    session_start();
    $uid = $_SESSION['user_id'] ?? null;
    if (!$uid || !\App\Models\User::class) {
      $this->redirect('/');
    }
    $userModel = new \App\Models\User();
    if (!$userModel->isAdmin((int)$uid)) {
      http_response_code(403);
      echo "403 Forbidden — у вас немає доступу";
      exit;
    }
  }
}
