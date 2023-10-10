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

if (empty($_POST['escola'])) {
    die($cfg['var_required']);
} else {
    $filtro = 1;
    $pessoa->idescola = filter_input(INPUT_POST, 'escola', FILTER_DEFAULT);
}

if (empty($_POST['matricula'])) {
    die($cfg['var_required']);
} else {
    $filtro++;
    $pessoa->matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
}

if (empty($_POST['nome'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $pessoa->nome = ucwords($_POST['nome']);
}

if (empty($_POST['cep'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['cep'] = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
    $pessoa->cep = $_POST['cep'];
}

if (empty($_POST['logradouro'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['logradouro'] = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
    $pessoa->logradouro = $_POST['logradouro'];
}

if (empty($_POST['numero'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['numero'] = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
    $pessoa->numero = $_POST['numero'];
}

if (empty($_POST['bairro'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['bairro'] = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
    $pessoa->bairro = $_POST['bairro'];
}

if (empty($_POST['cidade'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['cidade'] = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
    $pessoa->cidade = $_POST['cidade'];
}

if (empty($_POST['uf'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['uf'] = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $pessoa->uf = $_POST['uf'];
}

if (!empty($_POST['celular'])) {
    $_POST['celular'] = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
    $pessoa->celular = $_POST['celular'];
}

if (!empty($_POST['telefone'])) {
    $_POST['telefone'] = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $pessoa->telefone = $_POST['telefone'];
}

if (empty($_POST['email'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die($cfg['invalid_email']);
    } else {
        $pessoa->email = $_POST['email'];
    }
}

if (!empty($_POST['observacao'])) {
    $_POST['observacao'] = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
    $pessoa->observacao = $_POST['observacao'];
}

// confirma os filtros, tenta inserir o registro e retorna

if ($filtro == 10) {
    if ($pessoa->insert()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $pessoa, $filtro);