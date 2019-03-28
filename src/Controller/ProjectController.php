<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ProjectController
{

    /**
     * @var Twig
     */
    private $twig;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(Twig $twig, ProjectRepository $projectRepository)
    {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $args
     * @return ResponseInterface
     * @throws \Exception
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response, ?array $args)
    {
        $startedAt = new \DateTime('2019-03-27');
        $finishedAt = new \DateTime();


        $project = [
            "id" => 100,
            "name" => "Le site qui déchire!",
            "startedAt" => $startedAt,
            "finishedAt" => $finishedAt,
            "description" => '<h2>Site avec Slim Framework</h2><h3>Parce que vous le valez bien!</h3>',
            "image" => "site.png",
            "languages" => [ "html5","css3", "php7.1", "sql"]
        ];

        //return $response->getBody()->write('<h1>Projet</h1>');
        return $this->twig->render($response, 'project/show.twig', [
            'project' => $project
        ]);
    }


    public function create( ServerRequestInterface $request, ResponseInterface $response, ?array $args
    )
    {
        return $this->twig->render($response, 'project/create.twig');
    }
}
