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
    public function show(ServerRequestInterface $request, ResponseInterface $response, ?array $args): ResponseInterface
    {

        //récupération du projet
        $project = $this->projectRepository->findBySlug($args['slug']);

        //return $response->getBody()->write('<h1>Projet</h1>');
        return $this->twig->render($response, 'project/show.twig', [
            'project' => $project
        ]);
    }

    public function list(ServerRequestInterface $request, ResponseInterface $response
    ): ResponseInterface
    {
        $projects = $this->projectRepository->findAll();
        return $this->twig->render($response, 'project/list.twig', ['projects' => $projects]);
    }


    public function create( ServerRequestInterface $request, ResponseInterface $response, ?array $args
    ): ResponseInterface
    {
        if ($request->getMethod() ==='POST'){
            //TODO: vérifier tous les champs

            $this->projectRepository->insert($request->getParsedBody());

            //TODO: la redirection
        }

        return $this->twig->render($response, 'project/create.twig');
    }
}
