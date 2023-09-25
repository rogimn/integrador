<?php
class Pessoa {
    private $conn;
    public $idpessoa;

    // construtor da conexão com o banco

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // procura por registros

    public function check()
    {
        return $this->conn->query("SELECT idusuario FROM vw_pessoas");
    }

    // limpa a tabela

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE pessoas");
    }
}

unset ($conn, $db, $idpessoa);