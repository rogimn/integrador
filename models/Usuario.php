<?php
class Usuario
{
    private $conn;
    public $idusuario;
    public $tipo;
    public $nome;
    public $usuario;
    public $senha;
    public $email;
    public $monitor;

    // construtor da conexão com o banco

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // procura por registros

    public function check()
    {
        return $this->conn->query("SELECT idusuario FROM vw_usuarios");
    }

    // limpa a tabela

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE usuarios");
    }

    // verificação do login

    public function trust()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_usuarios WHERE usuario = :usuario AND senha = :senha");
        $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
        $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        $sql->execute();

        return $sql;
    }

    // lê todos os registros

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_usuarios WHERE monitor = :monitor ORDER BY tipo,nome,usuario,email");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }

    // lê um registro

    public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT idusuario, tipo, nome, usuario, senha, email FROM vw_usuarios WHERE idusuario = :idusuario");
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // verifica pelo mesmo registro antes de inserir

    public function recordInsertExist()
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

    // instalação

    public function install()
    {
        if ($this->recordInsertExist()) {
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

    // insere um registro

    public function insert()
    {
        if ($this->recordInsertExist()) {
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

    // verifica pelo mesmo registro antes de atualizar

    public function recordUpdateExist()
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

    // atualiza o registro

    public function update()
    {
        if ($this->recordUpdateExist()) {
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

    // inativa o registro

    public function delete()
    {
        $sql = $this->conn->prepare("CALL pd_usuario_delete(:monitor,:idusuario)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':idusuario', $this->idusuario, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }
}

unset($db, $conn, $sql, $idusuario, $tipo, $nome, $usuario, $senha, $email, $monitor);