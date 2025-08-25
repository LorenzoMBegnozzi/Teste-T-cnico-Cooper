<?php
require_once __DIR__ . '/Core/Router.php';
require_once __DIR__ . '/Controllers/ClientController.php';

$router = new Router();
$c = new ClientController();


$router->add(method: 'GET', path: '/clients', action: [$c, 'index']);
$router->add(method: 'GET', path: '/clients/create', action: [$c, 'create']);
$router->add(method: 'POST', path: '/clients/store', action: [$c, 'store']);
$router->add(method: 'GET', path: '/clients/edit/(\d+)', action: [$c, 'edit']);
$router->add(method: 'POST', path: '/clients/update/(\d+)', action: [$c, 'update']);
$router->add(method: 'GET', path: '/clients/delete/(\d+)', action: [$c, 'delete']);


$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url(url: $_SERVER['REQUEST_URI'], component: PHP_URL_PATH);
$router->dispatch(method: $method, uri: $uri);
