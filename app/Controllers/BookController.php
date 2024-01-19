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
}