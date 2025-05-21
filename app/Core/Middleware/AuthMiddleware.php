<?php
namespace App\Core\Middleware;

use App\Core\BaseController;

class AuthMiddleware implements MiddlewareInterface
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
     * Check if user is authenticated, redirect if not
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
        
        if (empty($_SESSION['user_id'])) {
            $this->controller->redirect($this->redirectPath);
        }
        
        return $next($request);
    }
}