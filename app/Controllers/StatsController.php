<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Stats;
use App\Models\Lesson;
use App\Core\Middleware\AuthMiddleware;

class StatsController extends BaseController
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(): void
  {
    $this->addMiddleware(new AuthMiddleware($this));
    $this->executeAction(function() {
      // No need for session start - middleware handles it
      // No need for authentication check - middleware handles it

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
        'lessons' => (new Lesson())->all()
      ]);
    });
  }

  public function create(): void
  {
    $this->addMiddleware(new AuthMiddleware($this));
    $this->executeAction(function() {
      header('Content-Type: application/json');
      
      // Отримуємо дані з POST запиту
      $json = json_decode(file_get_contents('php://input'), true);
      $lessonId = (int) ($json['lesson_id'] ?? 0);
      $wpm = (int) ($json['wpm'] ?? 0);
      $accuracy = (float) ($json['accuracy'] ?? 0);

      // Зберігаємо статистику користувача
      $ok = (new Stats())->create($_SESSION['user_id'], $lessonId, $wpm, $accuracy);

      echo json_encode(['success' => $ok]);
    });
  }
}