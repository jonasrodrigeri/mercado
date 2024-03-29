<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/database.php';

session_start();

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new JonasRodrigeri\Source\Router($method, $path);

$router->get('/', 'App\Controllers\HomeController::index');
$router->get('/404', 'App\Controllers\HomeController::error404');

$router->get('/produto', 'App\Controllers\ProdutoController::lista');
$router->get('/produto/inserir', 'App\Controllers\ProdutoController::inserir');
$router->get('/produto/editar/{id}', 'App\Controllers\ProdutoController::editar');
$router->get('/produto/exclui/{id}', 'App\Controllers\ProdutoController::exclui');
$router->post('/produto/insere', 'App\Controllers\ProdutoController::insere');
$router->post('/produto/edita/{id}', 'App\Controllers\ProdutoController::edita');

$router->get('/tipo-produto', 'App\Controllers\TipoProdutoController::lista');
$router->get('/tipo-produto/inserir', 'App\Controllers\TipoProdutoController::inserir');
$router->get('/tipo-produto/editar/{id}', 'App\Controllers\TipoProdutoController::editar');
$router->get('/tipo-produto/exclui/{id}', 'App\Controllers\TipoProdutoController::exclui');
$router->post('/tipo-produto/insere', 'App\Controllers\TipoProdutoController::insere');
$router->post('/tipo-produto/edita/{id}', 'App\Controllers\TipoProdutoController::edita');

$router->get('/venda', 'App\Controllers\VendaController::lista');
$router->get('/venda/inserir', 'App\Controllers\VendaController::inserir');
$router->get('/venda/visualizar/{id}', 'App\Controllers\VendaController::visualizar');
$router->get('/venda/limpar', 'App\Controllers\VendaController::limpar');
$router->get('/venda/finalizar', 'App\Controllers\VendaController::finalizar');
$router->get('/venda/remover-item', 'App\Controllers\VendaController::removerItem');
$router->post('/venda/insere', 'App\Controllers\VendaController::insere');

$result = $router->handler();

if (!$result) {
    return header("location: /404");
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