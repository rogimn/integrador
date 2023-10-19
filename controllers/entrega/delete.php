<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Entrega.php';

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$entrega = new Entrega($db);

// pré-definição de variáveis

$entrega->identrega = $_GET['' . $cfg['id']['entrega'] . ''];
$entrega->monitor = 0;

// tenta realizar a operação e retorna

if ($entrega->delete()) {
    $sql = $entrega->check();

    if ($sql->rowCount() == 0) {
        $entrega->truncate();
        
        echo 'true';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $entrega);