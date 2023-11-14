<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Entrega.php';

// controle de sessão

/*if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}*/

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// inicializa uma instância da classe

$entrega = new Entrega($db);

// controle

$entrega->monitor = 1;

// lê todos os registros

$sql = $entrega->readAll();

// verifica se há registros

if ($sql->rowCount() > 0) {
    $entrega_arr['entrega'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // format date and time

        $ano = substr($created_at, 0, 4);
        $mes = substr($created_at, 5, 2);
        $dia = substr($created_at, 8, 2);
        $hora = substr($created_at, 11, 8);
        $created_at = $dia . '/' . $mes . '/' . $ano . ' &#45; ' . $hora . 'h';

        $entrega_item = array(
            'status' => true,
            'identrega' => $identrega,
            'idescola' => $idescola,
            'escola' => $escola,
            'idpessoa' => $idpessoa,
            'pessoa' => $pessoa,
            'matricula' => $matricula,
            'codigo' => $codigo,
            'quantidade' => $quantidade,
            'created_at' => $created_at
        );

        array_push($entrega_arr['entrega'], $entrega_item);
    }

    echo json_encode($entrega_arr['entrega']);
} else {
    $entrega_arr['entrega'] = array();
    $entrega_item = array('status' => false);
    
    array_push($entrega_arr['entrega'], $entrega_item);
    
    echo json_encode($entrega_arr['entrega']);
}

unset($cfg, $database, $db, $entrega, $entrega_arr, $entrega_item, $sql, $row, $identrega, $idescola, $escola, $idpessoa, $pessoa, $matricula, $codigo, $quantidade, $created_at);