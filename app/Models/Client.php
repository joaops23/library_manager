<?php

namespace Model;

use Model\Abs\Model;
use Model\Interfaces\ModelInterface;

require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/ModelInterface.php";

class Client extends Model implements ModelInterface # Usando herança para reaproveitar classe
{
    public $tableName = "clients";

    public function insert($data){
        $data = json_decode($data, true);
        # Consulta o email do cliente no banco de dados
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE email = :email");
        $stmt->bindParam(":email", $data["email"]);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        if(count($result) > 0){
            return false;
        }
        # Insere o cliente na base de dados
        $stmt = $this->pdo->prepare("INSERT INTO $this->tableName (name, email, phone, address) VALUES (:name, :email, :phone, :address)");
        $stmt->bindParam(":name", $data["name"], \PDO::PARAM_STR);
        $stmt->bindParam(":email", $data["email"], \PDO::PARAM_STR);
        $stmt->bindParam(":phone", $data["phone"], \PDO::PARAM_STR);
        $stmt->bindParam(":address", $data["address"], \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function update($data, $id){
        $data = json_decode($data, true);
        $stmt = $this->pdo->prepare("UPDATE $this->tableName SET name = :name, email = :email, phone = :phone, address = :address WHERE id = :id");

        $stmt->bindParam(":name", $data["name"], \PDO::PARAM_STR);
        $stmt->bindParam(":email", $data["email"], \PDO::PARAM_STR);
        $stmt->bindParam(":phone", $data["phone"], \PDO::PARAM_STR);
        $stmt->bindParam(":address", $data["address"], \PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);

        $stmt->execute();
    }


    public function delete($id){
        $sqlConsult = "SELECT COUNT(*) FROM location WHERE client_id = :id and returned = '0'"; # Consulta se o livro está alocado
        $stmtConsult = $this->pdo->prepare($sqlConsult);
        $stmtConsult->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmtConsult->execute();

        if($stmtConsult->fetchColumn() == 0){ # Se não estiver locado, será excluído
            $this->deleteById($id);
            return true;
        } else{
            return false;
        }
    }
}