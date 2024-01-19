<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteCollectorProxy;
use Controllers\BookController;

require_once(_APP. "/Controllers/BookController.php");

$app->get("/", function(Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, "dashboard.html");
});

# Rotas de livros
$app->group("/books", function(RouteCollectorProxy $group){

    $group->get("", [BookController::class, 'index'])->setName("indexBook"); # Listagem e renderização 
    $group->post("", [BookController::class, 'store']);# Inclusão
    $group->delete("/{id}", [BookController::class, 'delete']);
    $group->patch("/{id}", [BookController::class, 'update']);
});



#busca por id

#alteração

#deleção

function process($args){
    $result = [];
    $data = explode("&", $args);
    foreach($data as $key => $val){
        $data_content = explode("=", $val);
        $result[$data_content[0]] = $data_content[1];
    }

    return  $result;
}

?>