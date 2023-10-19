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

// filtra as entradas

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

if (empty($_POST['identrega'])) {
    die($cfg['var_required']);
} else {
    $filtro = 1;
    $entrega->identrega = filter_input(INPUT_POST, 'identrega', FILTER_SANITIZE_NUMBER_INT);
}

if (empty($_POST['escola'])) {
    die($cfg['var_required']);
} else {
    $filtro++;
    $entrega->idescola = filter_input(INPUT_POST, 'escola', FILTER_SANITIZE_NUMBER_INT);
}

if (empty($_POST['pessoa'])) {
    die($cfg['var_required']);
} else {
    $filtro++;
    $entrega->idpessoa = filter_input(INPUT_POST, 'pessoa', FILTER_SANITIZE_NUMBER_INT);
}

if (empty($_POST['quantidade'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $entrega->quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
}

// confirma os filtros, tenta inserir o registro e retorna

if ($filtro == 4) {
    if ($entrega->update()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $entrega, $filtro);