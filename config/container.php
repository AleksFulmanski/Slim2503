<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;

use App\Model\Connection;
use App\Repository\ProjectRepository;
use App\TwigExtension\FormExtension;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Twig\Extension\DebugExtension;


//récupération du conteneur grace à App
$container = $app->getContainer();


//configuration de Twig

$container['view'] = function (ContainerInterface $container) {
    $view = new Twig(dirname(__DIR__) . '/templates', [
        'cache' => false,
        'strict_variables' => true,
        'debug' => true
    ]);

    //Ajout extension  de debug de Twig

    $view->addExtension(new DebugExtension());


    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    //extensions personnalisées
    $view->addExtension(new FormExtension($router, $uri));

    return $view;
};

// Création des clefs

//on crée une nouvelle clé ProjectController pour dire au container comment instancier
//ProjectController  (recuperer le Twig défini dans la function
//construct dans ProjectController
//il retourne une nouvelle instance de ProjectControlleur
//on obtient twig en envoyant la clef view du conteneur

$container[ProjectController::class] = function ($container) {
    return new ProjectController(
        $container->get('view'),
        $container->get(ProjectRepository::class)
    );
};

$container[ContactController::class] = function (ContainerInterface $container) {
    return new ContactController($container->get('view'));
};

$container[AboutController::class] = function ($container) {
    return new AboutController($container->get('view'));
};

$container[ProjectRepository::class] = function(ContainerInterface $container){
    return new ProjectRepository(
        $container->get(Connection::class)
    );
};

$container[Connection::class] = function(ContainerInterface $container){
    return new Connection(
        $container['settings']['database_name'],
        $container['settings']['database_user'],
        $container['settings']['database_pass']
    );
};
