<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new JonasRodrigeri\Source\Router($method, $path);

$router->get('/', function() {
    return 'Olá mundo';
});

$router->get('/ola-{nome}', 'App\Controllers\HomeController::hello');
$router->get('/users', 'App\Controllers\HomeController::listUsers');
$router->get('/produto/novo', 'App\Controllers\HomeController::insereProduto');

$result = $router->handler();

if (!$result) {
    http_response_code(404);
    die('Página não encontrada!');
}

$twig = require(__DIR__ . '/renderer.php');

if ($result instanceof Closure) {
    echo $result($router->getParams());
} elseif (is_string($result)) {

    $result = explode('::', $result);
    $controller = new $result[0]($twig);
    $action = $result[1];

    echo $controller->$action($router->getParams());
}