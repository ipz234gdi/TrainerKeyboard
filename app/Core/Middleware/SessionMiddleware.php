<?php

namespace App\Core\Middleware;

class SessionMiddleware implements MiddlewareInterface
{
    public function handle(array $request, callable $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $next($request);
    }
}