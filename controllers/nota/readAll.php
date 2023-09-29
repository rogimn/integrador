<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Nota.php';

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

$nota = new Nota($db);

// controle

$nota->idusuario = $_SESSION['id'];
$nota->monitor = 1;

// lê todos os registros

$sql = $nota->readAll();

// verifica se há registros

if ($sql->rowCount() > 0) {
    $nota_arr['nota'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // padroniza a data e hora

        $ano = substr($created_at, 0, 4);
        $mes = substr($created_at, 5, 2);
        $dia = substr($created_at, 8, 2);
        $hora = substr($created_at, 11, 8);
        $created_at = $dia . '/' . $mes . '/' . $ano . ' &#45; ' . $hora;

        $nota_item = array(
            'status' => true,
            'idnota' => $idnota,
            'codigo' => $codigo,
            'texto' => $texto,
            'created_at' => $created_at
        );

        array_push($nota_arr['nota'], $nota_item);
    }

    echo json_encode($nota_arr['nota']);
} else {
    $nota_arr['nota'] = array();
    $nota_item = array('status' => false);
    
    array_push($nota_arr['nota'], $nota_item);
    
    echo json_encode($nota_arr['nota']);
}

unset($cfg, $database, $db, $data, $nota, $nota_arr, $nota_item, $sql, $row, $idnota, $codigo, $texto, $dia, $mes, $ano, $created_at);