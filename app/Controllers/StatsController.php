<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Stats;

class StatsController extends BaseController
{
  public function index(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_SESSION['user_id']))
      $this->redirect('/');
    $data = (new Stats())->forUser($_SESSION['user_id']);
    $this->view('stats', ['data' => $data]);
  }

  public function create(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    header('Content-Type: application/json');
    if (empty($_SESSION['user_id'])) {
      http_response_code(403);
      echo json_encode(['error' => 'Not authenticated']);
      return;
    }
    $json = json_decode(file_get_contents('php://input'), true);
    $lessonId = (int) ($json['lesson_id'] ?? 0);
    $wpm = (int) ($json['wpm'] ?? 0);
    $accuracy = (float) ($json['accuracy'] ?? 0);
    $ok = (new Stats())->create($_SESSION['user_id'], $lessonId, $wpm, $accuracy);
    echo json_encode(['success' => $ok]);
  }
}
