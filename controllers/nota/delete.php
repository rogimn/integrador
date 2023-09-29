<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Nota.php';

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$nota = new Nota($db);

// pré-definição de variáveis

$nota->idnota = $_GET['' . $cfg['id']['nota'] . ''];
$nota->monitor = 0;

// tenta realizar a operação e retorna

if ($nota->delete()) {
    $sql = $nota->check();

    if ($sql->rowCount() == 0) {
        $nota->truncate();
        
        echo 'reload';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $nota);