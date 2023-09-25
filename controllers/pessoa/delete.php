<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Pessoa.php';

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$pessoa = new Pessoa($db);

// pré-definição de variáveis

$py_idpessoa = md5('idpessoa');
$pessoa->idpessoa = $_GET['' . $py_idpessoa . ''];
$pessoa->monitor = 0;

// tenta realizar a operação e retorna

if ($pessoa->delete()) {
    $sql = $pessoa->check();

    if ($sql->rowCount() == 0) {
        $pessoa->truncate();
        
        echo 'reload';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $pessoa, $py_idpessoa);