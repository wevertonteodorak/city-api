<?php

use Slim\Views\Twig;

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'app.html');
});

$app->get('/api/cidade', '\App\Cidade\Controllers\CidadeController:index');
$app->post('/api/cidade', '\App\Cidade\Controllers\CidadeController:store');
$app->put('/api/cidade/{id}', '\App\Cidade\Controllers\CidadeController:update');
$app->delete('/api/cidade/{id}', '\App\Cidade\Controllers\CidadeController:delete');

$app->get('/api/estado', '\App\Estado\Controllers\EstadoController:index');
$app->post('/api/estado', '\App\Estado\Controllers\EstadoController:store');
$app->put('/api/estado/{id}', '\App\Estado\Controllers\EstadoController:update');
$app->delete('/api/estado/{id}', '\App\Estado\Controllers\EstadoController:delete');