<?php

namespace Model;

use Model\Abs\Model;
use Model\Interfaces\ModelInterface;

require_once __DIR__ . "/Model.php";
require_once __DIR__ . "/ModelInterface.php";

class Location extends Model implements ModelInterface
{
    public $tableName = "location";

    public function insert($data){
        $data = json_decode($data, true);
        $locationDate = (int) $data['locationDate'] / 1000;
        $datetime = new \DateTime("@$locationDate");

        $stmt = $this->pdo->prepare("INSERT INTO $this->tableName (client_id, book_id, location_date, term) VALUES (:client_id, :book_id, :locationDate, :term)");
        $stmt->bindParam(":client_id", $data["client_id"], \PDO::PARAM_STR);
        $stmt->bindParam(":book_id", $data["book_id"], \PDO::PARAM_STR);
        $stmt->bindParam(":locationDate", $datetime->format("Y-m-d H:i:s"), \PDO::PARAM_STR);
        $stmt->bindParam(":term", $data["term"], \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function delete($id){
        $this->deleteById($id);
    }

    public function update($data, $id){}

    #Override
    public function selectAll(){
        $stmt = $this->pdo->prepare("SELECT `$this->tableName`.*, clients.name as 'client', books.title as 'book' FROM $this->tableName LEFT JOIN clients ON clients.id = `$this->tableName`.`client_id` LEFT JOIN books ON books.id = `$this->tableName`.`book_id`");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function devolution($returned, $id){
        $stmt = $this->pdo->prepare("UPDATE $this->tableName SET returned = '$returned' where id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}