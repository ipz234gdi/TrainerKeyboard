<?php
namespace App\Core\Middleware;

class MiddlewareStack
{
    /**
     * @var array
     */
    private array $middlewares = [];
    
    /**
     * Add middleware to the stack
     *
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function add(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }
    
    /**
     * Run the middleware stack with a final handler
     *
     * @param array $request
     * @param callable $handler
     * @return mixed
     */
    public function process(array $request, callable $handler)
    {
        $chain = $this->createChain($handler);
        return $chain($request);
    }
    
    /**
     * Create the middleware chain
     *
     * @param callable $handler
     * @return callable
     */
    private function createChain(callable $handler): callable
    {
        $middlewares = array_reverse($this->middlewares);
        $chain = $handler;
        
        foreach ($middlewares as $middleware) {
            $chain = function (array $request) use ($middleware, $chain) {
                return $middleware->handle($request, $chain);
            };
        }
        
        return $chain;
    }
}