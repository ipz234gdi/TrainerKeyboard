<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\{User, Lesson, Stats, Category};
use App\Core\Middleware\AdminMiddleware;
use App\Requests\LessonFormRequest; // Додано
use App\Services\AdminLessonService; // Додано
use Exception;

class AdminController extends BaseController
{
    private array $models = [];
    private AdminLessonService $adminLessonService; // Додано

    public function __construct()
    {
        parent::__construct();
        $this->addMiddleware(new AdminMiddleware($this));
        $this->models = [
            'user' => new User(),
            'lesson' => new Lesson(),
            'stats' => new Stats(),
            'category' => new Category()
        ];
        $this->adminLessonService = new AdminLessonService(); // Ініціалізація сервісу
    }

    /* Lesson Management */
    public function lessonsIndex(): void
    {
        $this->executeAction(function() {
            $this->renderLessonView('index', [
                'lessons' => $this->models['lesson']->all()
            ]);
        });
    }

    public function lessonsCreateForm(): void
    {
        $this->executeAction(function() {
            $this->renderLessonView('create');
        });
    }

    public function lessonsStore(): void
    {
        $this->executeAction(function() {
            $this->processLessonRequest('create');
        });
    }

    public function lessonsEditForm(): void
    {
        $this->executeAction(function() {
            $this->renderLessonView('edit', [
                'lesson' => $this->getLessonById()
            ]);
        });
    }

    public function lessonsUpdate(): void
    {
        $this->executeAction(function() {
            $this->processLessonRequest('update');
        });
    }

    public function lessonsDestroy(): void
    {
        $this->executeAction(function() {
            try {
                $this->models['lesson']->delete($this->getId());
                $this->redirect('/admin/lessons');
            } catch (Exception $e) {
                $this->handleError($e, 'lessons/index');
            }
        });
    }

    /* User Management */
    public function usersIndex(): void
    {
        $this->executeAction(function() {
            $this->view('admin/users/index', [
                'users' => $this->models['user']->all()
            ]);
        });
    }

    public function usersUpdateRole(): void
    {
        $this->executeAction(function() {
            $this->models['user']->updateRole(
                $this->getId(),
                $_POST['role'] ?? 'student'
            );
            $this->redirect('/admin/users');
        });
    }

    public function usersToggleBlock(): void
    {
        $this->executeAction(function() {
            $this->models['user']->setBlocked(
                $this->getId(),
                !((int) ($_POST['blocked'] ?? 0))
            );
            $this->redirect('/admin/users');
        });
    }

    /* Core Private Methods */
    private function processLessonRequest(string $action): void
    {
        $request = new LessonFormRequest();
        $data = $request->getData(); // Отримуємо дані для збереження у випадку помилки

        try {
            if (!$request->validate()) {
                // Якщо валідація не пройшла, кидаємо виняток з першою помилкою
                throw new Exception($request->getFirstError());
            }

            if ($action === 'create') {
                $this->adminLessonService->createLesson($data);
            } else {
                $this->adminLessonService->updateLesson($data);
            }

            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            $view = 'lessons/' . ($action === 'create' ? 'create' : 'edit');
            // Передаємо помилки валідації та введені дані у view
            $this->handleError($e, $view, $data, $request->getErrors());
        }
    }

    // ВИДАЛИТИ ЦЕЙ МЕТОД: getValidatedLessonData()
    // private function getValidatedLessonData(): array
    // {
    //    ... (весь вміст цього методу буде видалено)
    // }

    private function renderLessonView(string $view, array $data = []): void
    {
        $this->view("admin/lessons/$view", array_merge($data, [
            'categories' => $this->models['category']->all()
        ]));
    }

    private function getLessonById(): object
    {
        // Змінюємо отримання ID, щоб не покладатись на `getValidatedLessonData`
        return $this->models['lesson']->getById($this->getId());
    }

    private function getId(): int
    {
        return (int) ($_REQUEST['id'] ?? 0);
    }

    // Оновлений handleError для підтримки помилок валідації
    private function handleError(Exception $e, string $view, array $oldInput = [], array $validationErrors = []): void
    {
        error_log($e->getMessage()); // Логуємо реальну помилку
        $errorMessage = $e->getMessage(); // Використовуємо повідомлення з винятку

        $this->view("admin/$view", array_merge($oldInput, [ // Передаємо старі введені дані
            'error' => 'Operation failed: ' . $errorMessage, // Загальне повідомлення + деталі
            'validationErrors' => $validationErrors, // Новий параметр для помилок валідації
            'categories' => $this->models['category']->all()
        ]));
    }
}