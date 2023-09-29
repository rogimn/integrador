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

// filtra as entradas

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

if (empty($_POST['idnota'])) {
    die($cfg['var_required']);
} else {
    $filtro = 1;
    $_POST['idnota'] = filter_input(INPUT_POST, 'idnota', FILTER_DEFAULT);
    $nota->idnota = $_POST['idnota'];
}

if (empty($_POST['texto'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['texto'] = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING);
    $nota->texto = $_POST['texto'];
}

// confirma os filtros, tenta realizar a operação e retorna

if ($filtro == 2) {
    if ($nota->update()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $nota, $filtro);