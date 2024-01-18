<?php
namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use Model\Library;


$app->get("/", function(Request $request, Response $response, array $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, "dashboard.html");
});

$app->get("/books", function(Request $request, Response $response, array $args) {
    # busca os livros e retorna o template junto com a lista de livros
    $database = new Library();
    $view = Twig::fromRequest($request);
    return $view->render($response, "books.html");
});

$app->post("/login", function(Request $request, Response $response, array $args){
    $database = new Library();
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