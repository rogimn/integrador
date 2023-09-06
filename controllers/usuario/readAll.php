<?php

// call required files

require_once '../../config/app.php';
require_once '../../config/Database.php';
require_once '../../models/Usuario.php';

// user control

if (empty($_SESSION['key'])) {
    header('location:./');
}

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$usuario = new Usuario($db);

/*// function for decrypt password by openssl

function decrypt($data, $key)
{
    $len = strlen($key);

    if ($len < 16) {
        $key = str_repeat($key, ceil(16 / $len));
        $data = base64_decode($data);
        $val = openssl_decrypt($data, 'AES-256-OFB', $key, 0, $key);
        $val = str_replace(' ', '', $val);
    } else {
        die('N&atilde;o foi poss&iacute;vel descriptografar o login.');
    }

    return $val;
}*/

// config control

$usuario->monitor = 1;

// retrieve query

$sql = $usuario->readAll();

// check if more than 0 record found

if ($sql->rowCount() > 0) {
    $usuario_arr['usuario'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // decrypt the user and pass

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
    #$usuario_arr = array('status' => false);
    #echo json_encode($usuario_arr);

    $usuario_arr['usuario'] = array();
    $usuario_item = array('status' => false);
    
    array_push($usuario_arr['usuario'], $usuario_item);
    
    echo json_encode($usuario_arr['usuario']);
}

unset($cfg, $database, $db, $data, $usuario, $usuario_arr, $usuario_item, $key, $len, $val, $row, $idusuario, $tipo, $nome, $senha, $email);