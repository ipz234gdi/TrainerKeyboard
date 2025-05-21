<?php
namespace App\Core;

use App\Core\Middleware\MiddlewareStack;
use App\Core\Middleware\MiddlewareInterface;

abstract class BaseController
{
  /**
   * @var MiddlewareStack
   */
  protected MiddlewareStack $middleware;

  public function __construct()
  {
    $this->middleware = new MiddlewareStack();
  }

  /**
   * Add middleware to the stack
   *
   * @param MiddlewareInterface $middleware
   * @return $this
   */
  protected function addMiddleware(MiddlewareInterface $middleware): self
  {
    $this->middleware->add($middleware);
    return $this;
  }

  /**
   * Execute an action with middleware
   *
   * @param callable $action
   * @param array $request
   * @return mixed
   */
  protected function executeAction(callable $action, array $request = [])
  {
    return $this->middleware->process($request, $action);
  }

  /**
   * Render a view
   *
   * @param string $view
   * @param array $data
   * @return void
   */
  protected function view(string $view, array $data = []): void
  {
    extract($data);
    $viewFile = __DIR__ . '/../Views/' . $view . '.php';
    require __DIR__ . '/../Views/layouts/main.php';
  }

  /**
   * Redirect to another URL
   *
   * @param string $to
   * @return void
   */
  public function redirect(string $to): void
  {
    header("Location: {$to}");
    exit;
  }

  /**
   * Check if the current user is an admin
   *
   * @return void
   */
  protected function ensureAdmin(): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $uid = $_SESSION['user_id'] ?? null;
    if (!$uid || !\App\Models\User::class) {
      $this->redirect('/');
    }
    $userModel = new \App\Models\User();
    if (!$userModel->isAdmin((int) $uid)) {
      http_response_code(403);
      echo "403 Forbidden — у вас немає доступу";
      exit;
    }
  }
}