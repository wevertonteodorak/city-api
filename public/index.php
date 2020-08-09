<?php
//use Psr\Http\Message\ResponseInterface as Response;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use App\src\Exceptions\MyCustomErrorRenderer;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../resources/templates',
    ['cache' => __DIR__ . '/../cache']);

$app->add(TwigMiddleware::create($app, $twig));

require __DIR__ . '/../app/routes.php';

$app->run();    

