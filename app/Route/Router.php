<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Controllers\BookController;

require_once(_APP. "/Controllers/BookController.php");

$app->get("/", function(Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, "dashboard.html");
});

# Rotas de livros
$app->get("/books", [BookController::class, 'index'])->setName("indexBook"); # Listagem e renderização 


$app->post("/books", function(Request $request, Response $response, array $args){ # Inclusão
    $database = new Book();
    $contents = process($request->getBody()->getContents());
    
    $database->select("users", $contents); # Verifica se o usuário existe no sistema
    if(count($database->select("users", $contents)) == 0){
        $response->getBody()->write("Usuário não encontrado");
        return $response;
    } else {
        $response->getBody()->write("Usuário encontrado");
        return $response;
    }
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