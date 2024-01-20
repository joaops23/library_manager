<?php

namespace Model\Abs;

require_once (_APP. "/Models/Book.php");

abstract class Model extends \PDO
{ # Model genérico para reutilização de código
    protected $pdo;

    public function __construct(){
        $ctt = json_decode(file_get_contents( __DIR__ . "/../../env.json"), true); # Conteúdo do env.json
        $this->pdo = new \PDO("$ctt[driver]:dbname=$ctt[db];host=$ctt[host]", "$ctt[user]", "$ctt[pwd]");
    }

    public function selectAll(){
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tableName");
        $stmt->execute();
        return $stmt->fetchAll();
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

    public function deleteById($id){
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
    }
}