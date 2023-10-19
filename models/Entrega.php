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

    // lê todos os registros

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT identrega,idpessoa,pessoa,matricula,idescola,escola,codigo,quantidade,created_at FROM vw_entregas WHERE monitor = :monitor AND CAST(created_at AS VARCHAR) LIKE :created_at ORDER BY created_at,pessoa,matricula");
        $sql->bindParam(':created_at', $this->created_at, PDO::PARAM_STR);
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }

    // lê um único registro

    public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_entregas WHERE identrega = :identrega");
        $sql->bindParam(':identrega', $this->identrega, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // verifica pelo mesmo registro antes de inserir

    public function recordInsertExist()
    {
        $sql = $this->conn->prepare("SELECT identrega FROM vw_entregas WHERE codigo = :codigo");
        $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // insere um registro

    public function insert()
    {
        if ($this->recordInsertExist()) {
            die('Essa entrega j&aacute; j&aacute; foi registrada.');
        } else {
            $sql = $this->conn->prepare("CALL pd_entrega_insert(:idusuario, :idpessoa, :codigo, :quantidade)");
            $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
            $sql->bindParam(':idpessoa', $this->idpessoa, PDO::PARAM_INT);
            $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
            $sql->bindParam(':quantidade', $this->quantidade, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }

    /*// verifica pelo mesmo registro antes de atualizar

    public function recordUpdateExist()
    {
        $sql = $this->conn->prepare("SELECT identrega FROM vw_entregas WHERE codigo = :codigo AND idpessoa <> :idpessoa");
        $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $sql->bindParam(':idpessoa', $this->idpessoa, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }*/

    // insere um registro

    public function update()
    {
        /*if ($this->recordUpdateExist()) {
            die('Essa entrega j&aacute; j&aacute; foi registrada.');
        } else {*/
            $sql = $this->conn->prepare("CALL pd_entrega_update(:idpessoa, :quantidade, :identrega)");
            $sql->bindParam(':idpessoa', $this->idpessoa, PDO::PARAM_INT);
            $sql->bindParam(':quantidade', $this->quantidade, PDO::PARAM_INT);
            $sql->bindParam(':identrega', $this->identrega, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        #}
    }

    // inativa o registro

    public function delete()
    {
        $sql = $this->conn->prepare("CALL pd_entrega_delete(:monitor, :identrega)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':identrega', $this->identrega, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }
}