<?php
namespace App\src\Http;
use Slim\Psr7\Response;
//use Psr\Http\Message\ResponseInterface as Response;

class HttpResponse {

    static function string($data): Response {
        $res = new Response;
        $res->getBody()->write($data);
        return $res;
    }

    static function json(Array $data): Response {
        $payload = json_encode($data);
        $res = new Response;
        $res->getBody()->write($payload);
        return $res
            ->withHeader('Content-Type', 'application/json');
    }
}