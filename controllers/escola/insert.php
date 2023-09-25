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

if (empty($_POST['codigo'])) {
    die($cfg['var_required']);
} else {
    $escola->codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
}

if (empty($_POST['nome'])) {
    die($cfg['input_required']);
} else {
    $filtro = 1;
    $_POST['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $escola->nome = ucwords($_POST['nome']);
}

if (empty($_POST['cep'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['cep'] = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
    $escola->cep = $_POST['cep'];
}

if (empty($_POST['logradouro'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['logradouro'] = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_STRING);
    $escola->logradouro = $_POST['logradouro'];
}

if (empty($_POST['numero'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['numero'] = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
    $escola->numero = $_POST['numero'];
}

if (empty($_POST['bairro'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['bairro'] = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
    $escola->bairro = $_POST['bairro'];
}

if (empty($_POST['cidade'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['cidade'] = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING);
    $escola->cidade = $_POST['cidade'];
}

if (empty($_POST['uf'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['uf'] = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $escola->uf = $_POST['uf'];
}

if (!empty($_POST['celular'])) {
    $_POST['celular'] = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
    $escola->celular = $_POST['celular'];
}

if (!empty($_POST['telefone'])) {
    $_POST['telefone'] = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $escola->telefone = $_POST['telefone'];
}

if (empty($_POST['email'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die($cfg['invalid_email']);
    } else {
        $escola->email = $_POST['email'];
    }
}

if (!empty($_POST['observacao'])) {
    $_POST['observacao'] = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
    $escola->observacao = $_POST['observacao'];
}

// confirma os filtros, tenta realizar a operação e retorna

if ($filtro == 8) {
    if ($escola->insert()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $data, $key, $len, $m, $val, $database, $db, $escola, $enigma, $filtro);