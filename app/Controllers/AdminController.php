<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\{User, Lesson, Stats, Category};
use Exception;

class AdminController extends BaseController
{
    private array $models = [];

    public function __construct()
    {
        $this->ensureAdmin();
        $this->models = [
            'user' => new User(),
            'lesson' => new Lesson(),
            'stats' => new Stats(),
            'category' => new Category()
        ];
    }

    /* Lesson Management */
    public function lessonsIndex(): void
    {
        $this->renderLessonView('index', [
            'lessons' => $this->models['lesson']->all()
        ]);
    }

    public function lessonsCreateForm(): void
    {
        $this->renderLessonView('create');
    }

    public function lessonsStore(): void
    {
        $this->processLessonRequest('create');
    }

    public function lessonsEditForm(): void
    {
        $this->renderLessonView('edit', [
            'lesson' => $this->getLessonById()
        ]);
    }

    public function lessonsUpdate(): void
    {
        $this->processLessonRequest('update');
    }

    public function lessonsDestroy(): void
    {
        try {
            $this->models['lesson']->delete($this->getId());
            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            $this->handleError($e, 'lessons/index');
        }
    }

    /* User Management */
    public function usersIndex(): void
    {
        $this->view('admin/users/index', [
            'users' => $this->models['user']->all()
        ]);
    }

    public function usersUpdateRole(): void
    {
        $this->models['user']->updateRole(
            $this->getId(),
            $_POST['role'] ?? 'student'
        );
        $this->redirect('/admin/users');
    }

    public function usersToggleBlock(): void
    {
        $this->models['user']->setBlocked(
            $this->getId(),
            !((int) ($_POST['blocked'] ?? 0))
        );
        $this->redirect('/admin/users');
    }

    /* Core Private Methods */
    private function processLessonRequest(string $action): void
    {
        try {
            $data = $this->getValidatedLessonData();
            
            $action === 'create' 
                ? $this->models['lesson']->create($data)
                : $this->models['lesson']->update($data);
                
            $this->redirect('/admin/lessons');
        } catch (Exception $e) {
            $this->handleError($e, 'lessons/' . ($action === 'create' ? 'create' : 'edit'), $data ?? []);
        }
    }

    private function getValidatedLessonData(): array
    {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'lang' => $_POST['lang'] === 'en' ? 'en' : 'ua',
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'tags' => trim($_POST['tags'] ?? ''),
            'difficulty' => $_POST['difficulty'] ?? 'medium',
            'rating' => $_POST['rating'] ?? 0
        ];

        if (isset($_POST['id'])) {
            $data['id'] = $this->getId();
        }

        if (empty($data['title']) || empty($data['content'])) {
            throw new Exception('Required fields are missing');
        }

        return $data;
    }

    private function renderLessonView(string $view, array $data = []): void
    {
        $this->view("admin/lessons/$view", array_merge($data, [
            'categories' => $this->models['category']->all()
        ]));
    }

    private function getLessonById(): object
    {
        return $this->models['lesson']->getById($this->getId());
    }

    private function getId(): int
    {
        return (int) ($_REQUEST['id'] ?? 0);
    }

    private function handleError(Exception $e, string $view, array $data = []): void
    {
        error_log($e->getMessage());
        $this->view("admin/$view", array_merge($data, [
            'error' => 'Operation failed. Please try again.',
            'categories' => $this->models['category']->all()
        ]));
    }
}