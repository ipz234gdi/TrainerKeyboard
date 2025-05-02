<?php
namespace App\Core;

class Router {
  private array $routes = [];
  public function get(string $path, string $handler){ $this->add('GET',$path,$handler); }
  public function post(string $path, string $handler){ $this->add('POST',$path,$handler); }
  private function add($m,$p,$h){ $this->routes[$m][$this->norm($p)] = $h; }
  public function dispatch($uri,$method){
    $path = $this->norm(parse_url($uri,PHP_URL_PATH));
    if (!isset($this->routes[$method][$path])) {
      http_response_code(404); echo "404 Not Found"; exit;
    }
    [$c,$a] = explode('@',$this->routes[$method][$path]);
    (new $c())->{$a}();
  }
  private function norm($p){ return rtrim($p,'/')?: '/'; }
}
