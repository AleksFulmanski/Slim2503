<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Container\ContainerInterface;



//récupération du conteneur grace à App
$container = $app->getContainer();


//configuration de Twig

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(dirname(__DIR__) . '/templates', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// Création des clefs

//on crée une nouvelle clé ProjectController pour dire au container comment instancier
//ProjectController  (recuperer le Twig défini dans la function
//construct dans ProjectController
//il retourne une nouvelle instance de ProjectControlleur
//on obtient twig en envoyant la clef view du conteneur

$container[ProjectController::class] = function ($container) {
    return new ProjectController($container->get('view'));
};

$container[ContactController::class] = function (ContainerInterface $container) {
    return new ContactController($container->get('view'));
};

$container[AboutController::class] = function ($container) {
    return new AboutController($container->get('view'));
};
