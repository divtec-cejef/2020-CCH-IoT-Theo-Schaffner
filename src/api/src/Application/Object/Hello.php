<?php


namespace App\Application\Object;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Hello
{
    public function world (Request $request, Response $response, $args) {
        $response->getBody()->write('Hello world!');
        return $response;
    }

    public function worldWId (Request $request, Response $response, $args) {
        $response->getBody()->write('Hello world!'. $args['id']);
        return $response;
    }
}