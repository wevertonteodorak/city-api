<?php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../resources/templates',
    ['cache' => __DIR__ . '/../cache']);

$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$ErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    $payload = ['message' => $exception->getMessage()];
    $response = $app->getResponseFactory()->createResponse($exception->getCode() ?? 500);
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response;
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorMiddleware->setDefaultErrorHandler($ErrorHandler);
$errorHandler->forceContentType('application/json');

require __DIR__ . '/../app/routes.php';

return $app;

