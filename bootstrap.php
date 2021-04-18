<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/database.php';

session_start();

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new JonasRodrigeri\Source\Router($method, $path);

$router->get('/', function() {
    return 'Olá mundo';
});

$router->get('/ola-{nome}', 'App\Controllers\HomeController::hello');
$router->get('/users', 'App\Controllers\HomeController::listUsers');

$router->get('/produto', 'App\Controllers\ProdutoController::lista');
$router->get('/produto/inserir', 'App\Controllers\ProdutoController::inserir');
$router->get('/produto/editar/{id}', 'App\Controllers\ProdutoController::editar');
$router->get('/produto/exclui/{id}', 'App\Controllers\ProdutoController::exclui');
$router->post('/produto/insere', 'App\Controllers\ProdutoController::insere');
$router->post('/produto/edita/{id}', 'App\Controllers\ProdutoController::edita');

$router->get('/tipo-produto', 'App\Controllers\TipoProdutoController::lista');
$router->get('/tipo-produto/inserir', 'App\Controllers\TipoProdutoController::inserir');
$router->get('/tipo-produto/editar', 'App\Controllers\TipoProdutoController::editar');
$router->get('/tipo-produto/exclui', 'App\Controllers\TipoProdutoController::exclui');
$router->post('/tipo-produto/insere', 'App\Controllers\TipoProdutoController::insere');
$router->post('/tipo-produto/edita', 'App\Controllers\TipoProdutoController::edita');

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