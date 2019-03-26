<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProjectController
{

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response, ?array $args
    )
    {
        //return $response->getBody()->write('<h1>Projet</h1>');
        return $this->twig->render($response, 'project/show.twig');
    }


    public function create( ServerRequestInterface $request, ResponseInterface $response, ?array $args
    )
    {
        return $response->getBody()->write('<h1>Création d\'un projet</h1>');
    }
}
