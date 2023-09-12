<?php

// call required files

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Usuario.php';

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$usuario = new Usuario($db);

//filtering the inputs

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}
if (empty($_POST['idusuario'])) {
    die($cfg['var_required']);
} else {
    $filtro = 1;
    $_POST['idusuario'] = filter_input(INPUT_POST, 'idusuario', FILTER_DEFAULT);
    $usuario->idusuario = $_POST['idusuario'];
}

if (empty($_POST['tipo'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['tipo'] = filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT);
    $usuario->tipo = $_POST['tipo'];
}

if (empty($_POST['nome'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $usuario->nome = $_POST['nome'];
}

if (empty($_POST['usuario'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['usuario'] = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $usuario->usuario = encrypt($_POST['usuario'], $cfg['enigma']);
}

if (empty($_POST['senha'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['senha'] = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $usuario->senha = encrypt($_POST['senha'], $cfg['enigma']);
}

if (empty($_POST['email'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $_POST['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$_POST['email']) {
        die($cfg['invalid_email']);
    } else {
        $usuario->email = $_POST['email'];
    }
}

if ($filtro == 6) {
    if ($usuario->update()) {
        if (!empty($_POST['usuario_previous'])) {
            if ($_POST['usuario_previous'] != 'comum') {
                echo 'reload';
            } else {
                echo 'true';
            }
        }
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die('Vari&aacute;vel de controle nula.');
}

unset($cfg, $data, $key, $len, $m, $val, $database, $db, $usuario, $enigma, $filtro);