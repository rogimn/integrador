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

// filtra as entradas

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

// confirma os filtros, tenta realizar a operação e retorna

if ($filtro == 5) {
    if ($escola->update()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $data, $key, $len, $m, $val, $database, $db, $escola, $enigma, $filtro);