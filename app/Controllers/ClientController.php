<?php
namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Model\Client;
use Controllers\Abs\Controller;

require_once (_APP. "/Models/Client.php");

$client = new Client();

class ClientController extends Controller
{
    public function index(Request $request, Response $response, Array $args){
        global $client;

        $contents = $client->selectAll();
        $view = Twig::fromRequest($request);
        return $view->render($response, "clients.html", ["data" => $contents, "title" => "Clientes"]);
    }
    public function store(Request $request, Response $response, Array $args){
        global $client;
        $data = $this->process($request->getBody()->getContents());
        try{
            $newClient = $client->insert($data);

            if(!empty($newClient)){
                $response->withStatus(200);
                $response->getBody()->write("Cliente id $newClient inserido com sucesso!");
                return $response;
            } else {
                $response->withStatus(401);
                $response->getBody()->write("Cliente já cadastrado!");
                return $response;
            }
        } catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar inserir Cliente. Tente novamente!");
            return $response;
        }
    }
    public function update(Request $request, Response $response, Array $args){
        global $client;
        $data = $this->process($request->getBody()->getContents());
        $id = $args['id'];
        try{
            $client->update($data, $id);

            $response->withStatus(200);
            $response->getBody()->write("Cliente id $id atualizado com sucesso!");
            return $response;
        
        }
        catch(err){
            $response->withStatus(500);
            $response->getBody()->write("Erro ao tentar atualizar cliente. Tente novamente!");
            return $response;
        }
    }
    public function delete(Request $request, Response $response, Array $args){
        global $client;
        $id = $args['id'];
        $newClient = $client->delete($id);

        if($newClient){
            $response->withStatus(201);
            $response->getBody()->write("Cliente id $newClient Deletado!");
            return $response;
        } else{
            $response->withStatus(500);
            $response->getBody()->write("Não é possível remover cliente, confira se o mesmo possui livros alocados.");
            return $response;
        }
    }
}