<?php

namespace Model\Interfaces;

interface ModelInterface
{
    public function insert($data); # Inserção de novo registro no modelo
    public function select($where = array(), $fields = "*"); # busca de registro
    public function selectAll(); # busca de todos os registros da tabela
    public function delete($id); # Elimina um registro
    public function update($data, $id); # Altera um produto através de seu id
}