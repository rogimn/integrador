<?php

// chama os arquivos necessários

require_once '../../config/app.php';
require_once '../../models/Database.php';
require_once '../../models/Pessoa.php';

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

$pessoa = new Pessoa($db);

// controle

$pessoa->monitor = 1;

// lê todos os registros

$sql = $pessoa->readAll();

// verifica se há registros

if ($sql->rowCount() > 0) {
    $pessoa_arr['pessoa'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $pessoa_item = array(
            'status' => true,
            'idpessoa' => $idpessoa,
            'idescola' => $idescola,
            'escola' => $escola,
            'matricula' => $matricula,
            'nome' => $nome,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'telefone' => $telefone,
            'celular' => $celular,
            'email' => $email
        );

        array_push($pessoa_arr['pessoa'], $pessoa_item);
    }

    echo json_encode($pessoa_arr['pessoa']);
} else {
    $pessoa_arr['pessoa'] = array();
    $pessoa_item = array('status' => false);
    
    array_push($pessoa_arr['pessoa'], $pessoa_item);
    
    echo json_encode($pessoa_arr['pessoa']);
}

unset($cfg, $database, $db, $pessoa, $pessoa_arr, $pessoa_item, $sql, $row, $idpessoa, $idescola, $escola, $matricula, $nome, $logradouro, $numero, $bairro, $telefone, $celular, $email);