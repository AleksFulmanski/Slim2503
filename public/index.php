<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//création de l'application

$app = new App();

$app->get('/hello', function ( ServerRequestInterface $request, ResponseInterface $response, ?array $args
) {
    return $response->getBody()->write('<h1>Hello</h1>');
});
//création et renvoi de la réponse au navigateur
$app->run();
