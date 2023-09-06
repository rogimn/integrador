<?php

class Usuario
{
    // database connection

    private $conn;

    // object properties

    public $idusuario;
    public $tipo;
    public $nome;
    public $usuario;
    public $senha;
    public $email;
    public $monitor;

    // constructor with $db as database connection

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // check for records

    public function check()
    {
        return $this->conn->query("SELECT idusuario FROM vw_usuarios");
    }

    // truncate table

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE usuarios");
    }

    // validate login data

    public function trust()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_usuarios WHERE usuario = :usuario AND senha = :senha");
        $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
        $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        $sql->execute();

        return $sql;
    }

    // read all records

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_usuarios WHERE monitor = :monitor ORDER BY tipo,nome,usuario,email");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }

    // read single record

    public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT idusuario, tipo, nome, usuario, senha, email FROM vw_usuarios WHERE idusuario = :idusuario");
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // check for same record on insert

    public function userInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idusuario FROM vw_usuarios WHERE email = :email");
        $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // install

    public function install()
    {
        if ($this->userInsertExist()) {
            die('Esse e-mail j&aacute; est&aacute; vinculado em uma conta.');
        } else {
            // cadastra o usuário

            $sql = $this->conn->prepare("CALL pd_usuario_insert(:tipo,:nome,:usuario,:senha,:email)");
            $sql->bindParam(':tipo', $this->tipo, PDO::PARAM_BOOL);
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }
    }

    // insert record

    public function insert()
    {
        if ($this->userInsertExist()) {
            die('Esse e-mail j&aacute; est&aacute; vinculado em uma conta.');
        } else {
            $sql = $this->conn->prepare("CALL pd_usuario_insert(:tipo,:nome,:usuario,:senha,:email)");
            $sql->bindParam(':tipo', $this->tipo, PDO::PARAM_BOOL);
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }
    }

    // check for same record on update

    public function userUpdateExist()
    {
        $sql = $this->conn->prepare("SELECT idusuario FROM vw_usuarios WHERE email = :email AND idusuario <> :idusuario");
        $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // update record

    public function update()
    {
        if ($this->userUpdateExist()) {
            die('Essa usu&aacute;rio j&aacute; est&aacute; cadastrado.');
        } else {
            $sql = $this->conn->prepare("CALL pd_usuario_update(:tipo,:nome,:usuario,:senha,:email,:idusuario)");
            $sql->bindParam(':tipo', $this->tipo, PDO::PARAM_BOOL);
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }

    // delete record

    public function delete()
    {
        $sql = $this->conn->prepare("CALL procedure_delete_usuario(:monitor,:idusuario)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }
}

unset($db, $conn, $sql, $idusuario, $tipo, $nome, $usuario, $senha, $email, $monitor);