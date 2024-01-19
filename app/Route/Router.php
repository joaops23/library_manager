<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteCollectorProxy;
use Controllers\BookController;
use Controllers\ClientController;

require_once(_APP. "/Controllers/BookController.php");
require_once(_APP. "/Controllers/ClientController.php");

$app->get("/", function(Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, "dashboard.html");
});

# Rotas de livros
$app->group("/books", function(RouteCollectorProxy $group){

    $group->get("", [BookController::class, 'index'])->setName("indexBook"); # Listagem e renderização 
    $group->post("", [BookController::class, 'store']);# Inclusão
    $group->patch("/{id}", [BookController::class, 'update']); # Alteração
    $group->delete("/{id}", [BookController::class, 'delete']); # Exclusão
});

$app->group("/clients", function(RouteCollectorProxy $group){
    $group->get("", [ClientController::class, 'index'])->setName("indexBook"); # Listagem e renderização 
    $group->post("", [ClientController::class, 'store']);# Inclusão
    $group->patch("/{id}", [ClientController::class, 'update']); # Alteração
    $group->delete("/{id}", [ClientController::class, 'delete']); # Exclusão
});

?>