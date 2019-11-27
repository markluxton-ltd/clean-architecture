<?php

use core\interactors\userManagement\listUsers\ListUsersResponse;
use implementation\factories\interactors\ListUsersFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../src/delivery/slim/templates', [
      'cache' => false,
    ]);
    
    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
    
    return $view;
};

$app->get('/', function (Request $request, Response $response, $args)
{
    $presenter = new class implements \core\interfaces\boundaries\PresenterInterface {
    
        /**
         * @var ListUsersResponse
         */
        private $response;
        
        public function send(\core\classes\Response $response = null)
        {
            $this->response = $response;
        }
    
    
        public function getUsers(): array
        {
            return $this->response->getUsers();
        }
    };
    
    $useCase = (new ListUsersFactory())->create($presenter);
    $useCase->execute();
    
    return $this->view->render($response, 'listUsers.html', ['users'=>$presenter->getUsers()]);
    
})->setName('listUsers');

$app->run();

