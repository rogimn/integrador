<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Escola.php';

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$escola = new Escola($db);

// pré-definição de variáveis

$escola->idescola = $_GET['' . $cfg['id']['escola'] . ''];
$escola->monitor = 0;

// tenta realizar a operação e retorna

if ($escola->delete()) {
    $sql = $escola->check();

    if ($sql->rowCount() == 0) {
        $escola->truncate();
        
        echo 'true';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $escola);