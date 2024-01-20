<?php

namespace Model;

use Model\Abs\Model;
use Model\Interfaces\ModelInterface;

require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/ModelInterface.php";

class Book extends Model implements ModelInterface
{
    public $tableName = "books";

    

    public function insert($data){
        $data = json_decode($data, true);
        $sql = "INSERT INTO $this->tableName (title, author, description) VALUES (:title, :author, :description)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":title", $data['title'], \PDO::PARAM_STR);
        $stmt->bindParam(":author", $data['author'], \PDO::PARAM_STR);
        $stmt->bindParam(":description", $data['description'], \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function delete($id){
        $sqlConsult = "SELECT COUNT(*) FROM location WHERE book_id = :id and returned = '0'"; # Consulta se o livro está alocado
        $stmtConsult = $this->pdo->prepare($sqlConsult);
        $stmtConsult->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmtConsult->execute();

        if($stmtConsult->fetchColumn() == 0){ # Se não estiver locado, será excluído
            $this->deleteById($id);
        } else{
            $response->withStatus(500);
            $response->getBody()->write("Não é possível excluir um livro que está alocado!");
            return $response;
        }
    }

    public function update($data, $id){
        $data = json_decode($data, true);
        $sql = "UPDATE $this->tableName SET title = :title, author = :author, description = :description WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":title", $data['title'], \PDO::PARAM_STR);
        $stmt->bindParam(":author", $data['author'], \PDO::PARAM_STR);
        $stmt->bindParam(":description", $data['description'], \PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
    }
}