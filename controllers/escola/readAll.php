<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Escola.php';

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

$escola = new Escola($db);

// controle

$escola->monitor = 1;

// lê todos os registros

$sql = $escola->readAll();

// verifica se há registros

if ($sql->rowCount() > 0) {
    $escola_arr['escola'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $escola_item = array(
            'status' => true,
            'idescola' => $idescola,
            'codigo' => $codigo,
            'nome' => $nome,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'telefone' => $telefone,
            'celular' => $celular,
            'email' => $email
        );

        array_push($escola_arr['escola'], $escola_item);
    }

    echo json_encode($escola_arr['escola']);
} else {
    $escola_arr['escola'] = array();
    $escola_item = array('status' => false);
    
    array_push($escola_arr['escola'], $escola_item);
    
    echo json_encode($escola_arr['escola']);
}

unset($cfg, $database, $db, $data, $escola, $escola_arr, $escola_item, $key, $len, $val, $row, $idescola, $codigo, $nome, $logradouro, $numero, $bairro, $telefone, $celular, $email);