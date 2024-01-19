<?php
namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Model\Book;

require_once (_APP . "/Models/Book.php");

$book = new Book();

class BookController
{
    public function index(Request $request, Response $response, Array $args){
        global $book;

        $contents = $book->selectAll();
        $view = Twig::fromRequest($request);
        return $view->render($response, "books.html", ["data" => $contents]);
    }

    public function store(Request $request, Response $response, Array $args){
        global $book;
        $data = $this->process($request->getBody()->getContents());
        try{
            $newBook = $book->insert($data);

            $response->withStatus(201);
            $response->getBody()->write("Livro id $newBook inserido com sucesso");
            return $response;
        } catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar inserir livro. Tente novamente!");
            return $response;
        }
    }

    public function delete(Request $request, Response $response, Array $args){
        global $book;
        $id = $args['id'];
        try{
            $newBook = $book->delete($id);

            $response->withStatus(201);
            $response->getBody()->write("Livro id $newBook Deletado!");
            return $response;
        } catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar remover livro. Tente novamente!");
            return $response;
        }
    }

    public function update(Request $request, Response $response, Array $args){
        global $book;
        $data = $this->process($request->getBody()->getContents());
        $id = $args['id'];
        try{
            $newBook = $book->update($data, $id);
            
            $response->withStatus(200);
            $response->getBody()->write("Livro id $newBook atualizado com sucesso!");
            return $response;
        }
        catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar atualizar livro. Tente novamente!");
            return $response;
        }
    }


    protected function process($args){
        $result = [];
        $data = explode("&", $args);
        foreach($data as $key => $val){
            $data_content = explode("=", urldecode($val));
            $result[$data_content[0]] = $data_content[1];
        }

        $result = json_encode($result);
    
        return  $result;
    }
}