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

$pessoa->idpessoa = $_GET['' . $cfg['id']['pessoa'] . ''];
$pessoa->monitor = 0;

// tenta realizar a operação e retorna

if ($pessoa->delete()) {
    $sql = $pessoa->check();

    if ($sql->rowCount() == 0) {
        $pessoa->truncate();
        
        echo 'true';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $pessoa);