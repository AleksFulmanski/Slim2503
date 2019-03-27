<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 27/03/2019
 * Time: 11:21
 */

//création des routes

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


//page d'accueil
$route = $app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, ?array $args
) {
    //return $response->getBody()->write('<h1>Hello</h1>');
    return $this->view->render($response, 'home.twig');
});




$route->setName('homepage');

//groupe des routes du projet

$app->group('/projet', function () {

    //Page de création
    $this->get("/creation", ProjectController::class . ':create')->setName('app_project_create');

    // création d'une page de détail des projets
    //Nouveauté : on ajoute une variable dans l'URL avec des accolades
    $this->get("/{id:\d+}", ProjectController::class . ':show')->setName('app_project_show');

});

$app->get('/contact', ContactController::class . ':contact')->setName('app_contact');

$app->get('/about', AboutController::class . ':about')->setName('app_about');



