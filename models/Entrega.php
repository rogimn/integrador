<?php

class Entrega
{
    private $conn;
    public $identrega;
    public $idusuario;
    public $idpessoa;
    public $codigo;
    public $quantidade;
    public $monitor;
    public $created_at;

    // construtor da conexão com o banco

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // procura por registros

    public function check()
    {
        return $this->conn->query("SELECT identrega FROM vw_entregas");
    }

    // limpa a tabela

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE entregas");
    }

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT identrega,idpessoa,matricula,idescola,escola,codigo,quantidade,created_at FROM vw_entregas WHERE monitor = :monitor AND CAST(created_at AS VARCHAR) LIKE :created_at ORDER BY created_at,pessoa,matricula");
        $sql->bindParam(':created_at', $this->created_at, PDO::PARAM_STR);
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }
}