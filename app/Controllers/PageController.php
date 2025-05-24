<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Lesson;
use App\Models\Stats;
use App\Core\Middleware\AuthMiddleware;
use App\Services\LessonService;

class PageController extends BaseController
{
    private LessonService $lessonService;
    private Stats $statsModel;

    public function __construct()
    {
        parent::__construct();
        $this->addMiddleware(new AuthMiddleware($this));
        $this->lessonService = new LessonService();
        $this->statsModel = new Stats();
    }

    public function home(): void
    {
        $this->executeAction(function () {
            $lessonId = $_SESSION['current_lesson'] ?? null;
            $lesson = $this->lessonService->getLessonOrDefault($lessonId);
            $this->view('home', ['lesson' => $lesson]);
        });
    }

    public function lessons(): void
    {
        $this->executeAction(function () {
            $lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ua');
            $_SESSION['lang'] = in_array($lang, ['ua', 'en', 'all']) ? $lang : 'ua';
            $difficulty = $_GET['difficulty'] ?? 'medium';
            $minRating = (float) ($_GET['minRating'] ?? 0);

            $lessonsData = $this->lessonService->getFilteredLessons($lang, $difficulty, $minRating, $_SESSION['user_id']);
            $lessons = $lessonsData['lessons'];
            $completed = $lessonsData['completed'];

            $this->view('lessons', [
                'lessons' => $lessons,
                'lang' => $_SESSION['lang'],
                'completed' => $completed,
                'minRating' => $minRating,
                'difficulty' => $difficulty
            ]);

        });
    }

    public function startLesson(): void
    {
        $this->executeAction(function () {
            $lid = (int) ($_POST['lesson_id'] ?? 0);
            $_SESSION['current_lesson'] = $lid;

            $lesson = $this->lessonService->getLessonOrDefault($lid);
            $lang = $this->lessonService->getLessonLang($lid);

            $this->view('home', ['lesson' => $lesson, 'lang' => $lang]);
        });
    }

    public function stats(): void
    {
        $this->executeAction(function () {
            $userStats = $this->statsModel->forUser($_SESSION['user_id']);
            $allStats = $this->statsModel->allUsersStats();
            $this->view('stats', ['userStats' => $userStats, 'allStats' => $allStats]);
        });
    }
}
