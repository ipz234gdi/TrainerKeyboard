<?php
namespace App\Core\Middleware;

use App\Models\User;
use App\Core\BaseController;

class AdminMiddleware implements MiddlewareInterface
{
    /**
     * @var BaseController
     */
    private BaseController $controller;
    
    /**
     * @var string
     */
    private string $redirectPath;

    /**
     * @param BaseController $controller
     * @param string $redirectPath
     */
    public function __construct(BaseController $controller, string $redirectPath = '/')
    {
        $this->controller = $controller;
        $this->redirectPath = $redirectPath;
    }

    /**
     * Check if user is authenticated and is an admin, redirect if not
     *
     * @param array $request
     * @param callable $next
     * @return mixed
     */
    public function handle(array $request, callable $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $uid = $_SESSION['user_id'] ?? null;
        
        if (!$uid) {
            $this->controller->redirect($this->redirectPath);
        }
        
        $userModel = new User();
        
        if (!$userModel->isAdmin((int) $uid)) {
            http_response_code(403);
            echo "403 Forbidden — у вас немає доступу";
            exit;
        }
        
        return $next($request);
    }
}