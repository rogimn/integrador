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

// filtra as entradas

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

// confirma os filtros, tenta inserir o registro e retorna

if ($filtro == 5) {
    if ($pessoa->insert()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $data, $key, $len, $m, $val, $database, $db, $pessoa, $enigma, $filtro);