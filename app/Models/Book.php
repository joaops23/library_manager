<?php

namespace Model;

class Book extends \PDO
{
    private $pdo;
    public $tableName = "books";

    public function __construct(){
        #$ctt = json_decode(file_get_contents( __DIR__ . "./../../env.json"), true); # Conteúdo do env.json
        $ctt = [
            "host" => "127.0.0.1",
            "user" => "root",
            "pwd" => "1045",
            "db" => "library",
            "driver" => "mysql"
        ];
        $this->pdo = new \PDO("$ctt[driver]:dbname=$ctt[db];host=$ctt[host]", "$ctt[user]", "$ctt[pwd]");
    }

    public function select($where = array(), $fields = "*"){
        $cond = [];
        $where_str = "";
        foreach($where as $w => $value){
            $where_str .= " and ";
            $where_str .= $w . " = :$w "; # As aspas são para evitar possível SQL Injection
            $cond["$w"] = $value;
        }

        $sql = "SELECT $fields from $this->tableName where 1 $where_str";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($cond);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function selectAll(){
        $sql = "SELECT * from $this->tableName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

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
            $sql = "DELETE FROM $this->tableName WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
            $stmt->execute();
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