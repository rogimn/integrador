<?php

// limpa o cache

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
require_once '../models/Pessoa.php';

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

$pessoa = new Pessoa($db);

// Variáveis de controle

$pessoa->idpessoa = $_GET['' . $cfg['id']['pessoa'] . ''];

// executa a consulta e retorna

if ($sql = $pessoa->readSingle()) {
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
?>



<?php
    } else {
        echo
        '<blockquote class="quote-danger">
            <h5>' . $cfg['error']['title'] . '</h5>
            <p>' . $cfg['error']['msg'] . '</p>
        </blockquote>';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $pessoa, $sql, $row);