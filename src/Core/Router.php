<?php
class Router {
    private array $routes = []; //guarda as rotas cadastradas

    public function add(string $method, string $path, callable $action): void {
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch(string $method, string $uri) {
        foreach ($this->routes as $r) {
            if ($method === $r['method'] && preg_match(pattern: "#^{$r['path']}$#", subject: $uri, matches: $matches)) {
                //verifica se o motod e rota sao =, e verifica se o URl acessada (uri) bate com padrao de rota (path), e depois 
                //matches que é um array, vai guardar as rotas e numeros
                array_shift(array: $matches);// aqui o array_Shift desfaz o array, e deixa somente o parametro
                return call_user_func_array(callback: $r['action'], args: $matches);
            }   
        }
        http_response_code(response_code: 404);
        echo 'Pgina não encontrada';
    }
}
