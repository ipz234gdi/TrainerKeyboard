<?php

namespace App\Core\Middleware;

class DefaultErrorHandler implements ErrorHandlerInterface
{
  public function handleForbidden(): void
  {
    http_response_code(403);
    echo "403 Forbidden — у вас немає доступу";
    exit;
  }
}
