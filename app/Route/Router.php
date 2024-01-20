<?php

# Configuração de namespaces
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteCollectorProxy;
use Controllers\BookController;
use Controllers\ClientController;
use Controllers\LocationController;

# Importação de controlladores
require_once(_APP. "/Controllers/BookController.php");
require_once(_APP. "/Controllers/ClientController.php");
require_once(_APP. "/Controllers/LocationController.php");

#rota inicial
$app->get("/", function(Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, "dashboard.html");
});

# Rotas de livros
$app->group("/books", function(RouteCollectorProxy $group){

    $group->get("", [BookController::class, 'index']); # Listagem e renderização 
    $group->post("", [BookController::class, 'store']);# Inclusão
    $group->patch("/{id}", [BookController::class, 'update']); # Alteração
    $group->delete("/{id}", [BookController::class, 'delete']); # Exclusão
});

$app->group("/clients", function(RouteCollectorProxy $group){
    $group->get("", [ClientController::class, 'index']); # Listagem e renderização 
    $group->post("", [ClientController::class, 'store']);# Inclusão
    $group->patch("/{id}", [ClientController::class, 'update']); # Alteração
    $group->delete("/{id}", [ClientController::class, 'delete']); # Exclusão
});

$app->group("/locations", function(RouteCollectorProxy $group){
    $group->get("", [LocationController::class, 'index']); # Listagem e renderização 
    $group->post("", [LocationController::class,'store']);# Inclusão
    $group->delete("/{id}", [LocationController::class, 'delete']); # Exclusão
    $group->put("/devolution/{id}", [LocationController::class, 'devolution']); # Gera a devolução do item
})

?>