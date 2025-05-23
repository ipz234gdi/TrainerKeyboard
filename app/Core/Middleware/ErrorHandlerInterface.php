<?php

namespace App\Core\Middleware;

interface ErrorHandlerInterface
{
  public function handleForbidden(): void;
}
