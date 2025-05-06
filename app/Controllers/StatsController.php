<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Stats;

class StatsController extends BaseController
{
  public function index(): void
  {
    if (session_status() === PHP_SESSION_NONE)
      session_start();
    if (empty($_SESSION['user_id']))
      $this->redirect('/');

    // Забираємо фільтри з query-string
    $from = $_GET['from'] ?? null;
    $to = $_GET['to'] ?? null;
    $lessonId = (int) ($_GET['lesson'] ?? 0);

    $statsModel = new Stats();
    $userStats = $statsModel->forUserFiltered($_SESSION['user_id'], $from, $to, $lessonId);
    $allStats = $statsModel->allUsersStatsFiltered($from, $to, $lessonId);

    // Для побудови графіку WPM від дати
    $chartData = array_map(function ($row) {
      return [
        'date' => substr($row['created_at'], 0, 10),
        'wpm' => (int) $row['wpm'],
      ];
    }, $userStats);

    $this->view('stats', [
      'userStats' => $userStats,
      'allStats' => $allStats,
      'chartData' => $chartData,
      'filter' => compact('from', 'to', 'lessonId'),
      'lessons' => (new \App\Models\Lesson())->all()
    ]);
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
