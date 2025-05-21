<?php
namespace App\Core\Middleware;

interface MiddlewareInterface
{
    /**
     * Handle the request and decide whether to continue or stop processing
     *
     * @param array $request The request data to process
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle(array $request, callable $next);
}