<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Stats;
use App\Models\User;
use App\Models\Lesson;
use App\Core\Middleware\AuthMiddleware;

class ProfileController extends BaseController
{
    private Stats $statsModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->statsModel = new Stats();
        $this->userModel = new User();
    }

    public function showProfile(): void
    {
        $this->addMiddleware(new AuthMiddleware($this));
        $this->executeAction(function() {
            // No need for session start - middleware handles it
            // No need for authentication check - middleware handles it

            $userId = $_SESSION['user_id'];

            // Отримуємо статистику користувача
            $stats = $this->statsModel->forUser($userId);

            // Отримуємо інформацію про користувача
            $user = $this->userModel->findById($userId);

            // Отримуємо доступні уроки
            $lessons = (new Lesson())->all();

            // Обчислюємо середню швидкість та точність для статистики
            $averageStats = $this->statsModel->getAverageStats($userId);

            // Передаємо дані у вювер
            $this->view('profile', [
                'user' => $user,
                'lessonStats' => $stats,
                'lessons' => $lessons,
                'averageStats' => $averageStats,
            ]);
        });
    }
}