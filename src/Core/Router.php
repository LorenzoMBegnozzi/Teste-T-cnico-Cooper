<?php
class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $action): void {
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch(string $method, string $uri) {
        foreach ($this->routes as $r) {
            if ($method === $r['method'] && preg_match(pattern: "#^{$r['path']}$#", subject: $uri, matches: $matches)) {
                array_shift(array: $matches);
                return call_user_func_array(callback: $r['action'], args: $matches);
            }
        }
        http_response_code(response_code: 404);
        echo 'Pgina não encontrada';
    }
}
