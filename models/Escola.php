<?php
class Escola
{
    private $conn;
    public $idescola;
    public $codigo;
    public $nome;
    public $cep;
    public $logradouro;
    public $numero;
    public $bairro;
    public $cidade;
    public $uf;
    public $celular;
    public $telefone;
    public $email;
    public $observacao;
    public $monitor;

    // construtor da conexão com o banco

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // procura por registros

    public function check()
    {
        return $this->conn->query("SELECT idescola FROM vw_escolas");
    }

    // limpa a tabela

    public function truncate()
    {
        return $this->conn->query("TRUNCATE TABLE escolas");
    }

    // lê todos os registros

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_escolas WHERE monitor = :monitor ORDER BY bairro,nome,cep,logradouro,numero");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }

    // lê um único registro

    public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT * FROM vw_escolas WHERE idescola = :idescola");
        $sql->bindParam(':idescola', $this->idescola, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // verifica pelo mesmo registro antes de inserir

    public function recordInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idescola FROM vw_escolas WHERE (codigo = :codigo OR nome = :nome OR email = :email)");
        $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
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
            die('Essa escola j&aacute; est&aacute; cadastrada.');
        } else {
            $sql = $this->conn->prepare("CALL pd_escola_insert(:codigo,:nome,:cep,:logradouro,:numero,:bairro,:cidade,:uf,:celular,:telefone,:email,:observacao)");
            $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':cep', $this->cep, PDO::PARAM_STR);
            $sql->bindParam(':logradouro', $this->logradouro, PDO::PARAM_STR);
            $sql->bindParam(':numero', $this->numero, PDO::PARAM_STR);
            $sql->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
            $sql->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
            $sql->bindParam(':uf', $this->uf, PDO::PARAM_STR);
            $sql->bindParam(':celular', $this->celular, PDO::PARAM_STR);
            $sql->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->bindParam(':observacao', $this->observacao, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }
    }

    // verifica pelo mesmo registro antes de atualizar

    public function recordUpdateExist()
    {
        $sql = $this->conn->prepare("SELECT idescola FROM vw_escolas WHERE (codigo = :codigo OR nome = :nome OR email = :email) AND idescola <> :idescola");
        $sql->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
        $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
        $sql->bindParam(':idescola', $this->idescola, PDO::PARAM_INT);
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
            die('Essa escola j&aacute; est&aacute; cadastrada.');
        } else {
            $sql = $this->conn->prepare("CALL pd_escola_update(:nome,:cep,:logradouro,:numero,:bairro,:cidade,:uf,:celular,:telefone,:email,:observacao,:idescola)");
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':cep', $this->cep, PDO::PARAM_STR);
            $sql->bindParam(':logradouro', $this->logradouro, PDO::PARAM_STR);
            $sql->bindParam(':numero', $this->numero, PDO::PARAM_STR);
            $sql->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
            $sql->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
            $sql->bindParam(':uf', $this->uf, PDO::PARAM_STR);
            $sql->bindParam(':celular', $this->celular, PDO::PARAM_STR);
            $sql->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->bindParam(':observacao', $this->observacao, PDO::PARAM_STR);
            $sql->bindParam(':idescola', $this->idescola, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }

    // inativa o registro

    public function delete()
    {
        $sql = $this->conn->prepare("CALL pd_escola_delete(:monitor,:idescola)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':idescola', $this->idescola, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }
}

unset($db, $conn, $sql, $idescola, $codigo, $nome, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $celular, $telefone, $email, $observacao, $monitor);