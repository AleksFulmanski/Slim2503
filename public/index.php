<?php

use App\Controller\AboutController;
use App\Controller\ContactController;
use App\Controller\ProjectController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

//création de l'application
//debug des erreurs (a configurer manuellement depuis l'exemple de la doc application/configuration
$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app = new App($config);

//configuration de Twig
// Get container
$container = $app->getContainer();



// Register component on container
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



//création des routes

$route = $app->get('/', function ( ServerRequestInterface $request, ResponseInterface $response, ?array $args
) {
    //return $response->getBody()->write('<h1>Hello</h1>');
    return $this->view->render($response, 'home.twig');
});




$route->setName('homepage');


$app->group('/projet', function () {
    // création d'une page de détail des projets
    //Nouveauté : on ajoute une variable dans l'URL avec des accolades
    $this->get("/{id:\d+}", ProjectController::class . ':show')->setName('app_project_show');

    //Page de création
    $this->get("/creation", ProjectController::class . ':create')->setName('app_project_create');
});

$app->get('/contact', ContactController::class . ':contact')->setName('app_contact');

$app->get('/about', AboutController::class . ':about')->setName('app_about');





//création et renvoi de la réponse au navigateur
$app->run();
