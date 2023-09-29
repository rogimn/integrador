<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Usuario.php';

// controle de sessão

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// inicializa uma instância da classe

$usuario = new Usuario($db);

// controle

$usuario->monitor = 1;

// lê todos os registros

$sql = $usuario->readAll();

// verifica se há registros

if ($sql->rowCount() > 0) {
    $usuario_arr['usuario'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // descriptografa o login

        $usuario = decrypt($usuario, $cfg['enigma']);
        #$senha = decrypt($senha, $cfg['enigma']);

        $usuario_item = array(
            'status' => true,
            'idusuario' => $idusuario,
            'tipo' => $tipo,
            'nome' => $nome,
            'usuario' => $usuario,
            'senha' => $senha,
            'email' => $email
        );

        array_push($usuario_arr['usuario'], $usuario_item);
    }

    echo json_encode($usuario_arr['usuario']);
} else {
    $usuario_arr['usuario'] = array();
    $usuario_item = array('status' => false);
    
    array_push($usuario_arr['usuario'], $usuario_item);
    
    echo json_encode($usuario_arr['usuario']);
}

unset($cfg, $database, $db, $usuario, $usuario_arr, $usuario_item, $sql, $row, $idusuario, $tipo, $nome, $usuario, $senha, $email);