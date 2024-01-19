<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Factory\AppFactory;

require __DIR__ . "/../vendor/autoload.php";
define("_APP", dirname(__FILE__). "/../app");

#iniciando servidor Slim
$app = AppFactory::create();

$twig = Twig::create('../app/views', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));
#implementar twig como template engine

require_once(_APP . "/Route/Router.php");

$app->run();
?>