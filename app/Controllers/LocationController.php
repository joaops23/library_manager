<?php

namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Model\Client;
use Model\Book;
use Model\Location;
use Controllers\Abs\Controller;

require_once (_APP. "/Models/Client.php");
require_once (_APP. "/Models/Book.php");
require_once(_APP. "/Models/Location.php");

$location = new Location();
$client = new Client();
$book = new Book();

class LocationController extends Controller {
    
    public function index(Request $request, Response $response, Array $args){
        global $location, $client, $book;

        $clients = $client->selectAll();
        $books = $book->selectAll();
        $data = $location->selectAll();

        $content = [];
        foreach($data as $d){
            $id = $d['id'];
            $d["locationDate"] = date("d/m/Y", strtotime($d['location_date']));
            $content[] = $d;
        }
        $view = Twig::fromRequest($request);
        return $view->render($response, "locations.html", ["data" => $content, "title" => "Locações", "clients" => $clients, "books" => $books]);
    }

    public function store(Request $request, Response $response, Array $args){
        global $location;
        $data = $this->process($request->getBody()->getContents());

        try{
            $dataConsult = json_decode($data, true);
            $consult = $location->select(["client_id" => $dataConsult['client_id'],  "book_id" => $dataConsult['book_id']]); # busca se tem locação para o cliente e o livro

            if(count($consult)  == 0){
                $newLocation = $location->insert($data);
                $response->withStatus(201);
                $response->getBody()->write("Locação id: $newLocation inserida com sucesso!");
                return $response;
            } else{
                $response->withStatus(401);
                $response->getBody()->write("Livro já alocado para este cliente!");
                return $response;
            }
        }
        catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar inserir Locação. Tente novamente!");
            return $response;
        }
    }

    public function delete(Request $request, Response $response, Array $args){
        global $location;
        $id = $args['id'];
        try{

            $location->delete($id);

            $response->withStatus(201);
            $response->getBody()->write("Locação id $id deletada com sucesso!");
            return $response;
        }catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar remover Locação. Tente novamente!");
            return $response;
        }
    }

    public function devolution(Request $request, Response $response, Array $args){
        global $location;
        $id = $args['id'];
        try{
            $data = [
                "returned" => 1
            ];
            $location->devolution('1', $id);

            $response->withStatus(201);
            $response->getBody()->write("Locação id $id devolvida com sucesso!");
            return $response;

        }catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar atualizar a Locação. Tente novamente!");
            return $response;
        }
    }
}