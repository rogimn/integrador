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

$py_idescola = md5('idescola');
$escola->idescola = $_GET['' . $py_idescola . ''];
$escola->monitor = 0;

// tenta realizar a operação e retorna

if ($escola->delete()) {
    $sql = $escola->check();

    if ($sql->rowCount() == 0) {
        $escola->truncate();
        
        echo 'reload';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $escola, $py_idescola);