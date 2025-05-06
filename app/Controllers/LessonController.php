<?php
// app/Controllers/LessonController.php
namespace App\Controllers;
use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Stats;

class LessonController extends BaseController
{
  public function index(): void
  {
    if (session_status() === PHP_SESSION_NONE)
      session_start();
    if (empty($_SESSION['user_id'])) {
      $this->view('index');
      return;
    }

    $userId = (int) $_SESSION['user_id'];
    $lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ua');
    $_SESSION['lang'] = in_array($lang, ['ua', 'en']) ? $lang : 'ua';

    // Вибрати уроки лише для цієї мови
    $lessons = (new Lesson())->allByLang($_SESSION['lang']);

    // Отримати ID вже пройдених уроків
    $completed = (new Stats())->completedLessons($userId);

    $this->view('lessons', [
      'lessons' => $lessons,
      'lang' => $_SESSION['lang'],
      'completed' => $completed
    ]);
  }

  // public function start(): void
  // {
  //   if (session_status() === PHP_SESSION_NONE)
  //     session_start();
  //   if (empty($_SESSION['user_id']))
  //     $this->redirect('/');
  //   $lid = (int) ($_POST['lesson_id'] ?? 0);
  //   $wpm = (int) ($_POST['wpm'] ?? 0);
  //   $acc = (float) ($_POST['accuracy'] ?? 0);
  //   (new \App\Models\Stats())->create($_SESSION['user_id'], $lid, $wpm, $acc);
  //   $this->redirect('/stats');
  // }

  public function search(): void
  {
    // Отключаем HTML-ошибки, отдаем только JSON
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

    header('Content-Type: application/json; charset=utf-8');
    if (session_status() === PHP_SESSION_NONE)
      session_start();
    if (empty($_SESSION['user_id'])) {
      http_response_code(401);
      echo json_encode(['error' => 'Unauthorized']);
      return;
    }

    $q = trim($_GET['query'] ?? '');
    $lang = $_SESSION['lang'] ?? 'ua';

    $lessons = [];
    if ($q !== '') {
      // вызываем модель
      $lessons = (new Lesson())->search($q, $lang);
    }

    echo json_encode($lessons);
  }

}
