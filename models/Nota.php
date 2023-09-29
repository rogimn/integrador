<?php

class Nota
{
    private $conn;

    public $idnota;
    public $idusuario;
    public $codigo;
    public $texto;
    public $monitor;

    // construtor da conexão com o banco

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // procura por registros

    public function check()
    {
        return $this->conn->query("SELECT idnota FROM vw_notas");
    }

    // limpa a tabela

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE notas");
    }

    // lê todos os registros

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_notas WHERE idusuario = :idusuario AND monitor = :monitor ORDER BY created_at, codigo, texto");
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }

    // lê um único registro

    public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_notas WHERE idnota = :idnota");
        $sql->bindParam(':idnota', $this->idnota, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // verifica pelo mesmo registro antes de inserir

    public function recordInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idnota FROM vw_notas WHERE codigo = :codigo");
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
            die('Esse nota j&aacute; est&aacute; cadastrada.');
        } else {
            $sql = $this->conn->prepare("CALL pd_nota_insert(:idusuario, :codigo, :texto)");
            $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
            $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
            $sql->bindParam(':texto', $this->texto, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }
    }

    // verifica pelo mesmo registro antes de atualizar

    public function recordUpdateExist()
    {
        $sql = $this->conn->prepare("SELECT idnota FROM vw_notas WHERE codigo = :codigo AND idnota <> :idnota");
        $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $sql->bindParam(':idnota', $this->idnota, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // atualiza o registro

    public function update()
    {
        if ($this->recordUpdateExist()) {
            die('Essa nota j&aacute; est&aacute; cadastrada.');
        } else {
            $sql = $this->conn->prepare("CALL pd_nota_update(:texto, :idnota)");
            $sql->bindParam(':texto', $this->texto, PDO::PARAM_STR);
            $sql->bindParam(':idnota', $this->idnota, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }

    // inativa o registro

    public function delete()
    {
        $sql = $this->conn->prepare("CALL pd_nota_delete(:monitor, :idnota)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':idnota', $this->idnota, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }
}

unset($db, $conn, $sql, $idnota, $idusuario, $codigo, $texto, $monitor);