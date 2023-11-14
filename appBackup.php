<?php
// chamada de arquivos necessários

require_once 'config/app.php';
#require_once 'models/Database.php';

// controle de sessão ativa

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

// abre a conexão com o banco

#$database = new Database();
#$db = $database->getConnection();

// executa a exportação 
// método I: pg_dump -h localhost -p 5432 -U usuario banco_de_dados > destino.sql
// método II: pg_dump --dbname=postgresql://usuario:senha@servidor:porta/banco_de_dados > destino.sql

if (!exec('pg_dump -h localhost -p 5432 -U rogim integrador > db/bkp/' . date('Ymd_hisa') . '.sql', $output, $result)) {
    if (!$output) {
        echo 'true';
    }
}

unset($cfg, $database, $db, $output, $result);
