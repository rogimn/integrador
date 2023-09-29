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

// set variables

$usuario->idusuario = $_GET['' . $cfg['id']['usuario'] . ''];
$usuario->monitor = 0;

if ($usuario->delete()) {
    $sql = $usuario->check();

    if ($sql->rowCount() == 0) {
        $usuario->truncate();
        rename('appInstallDone.php', 'appInstall.php');
        echo 'reload';
    } else {
        echo 'true';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $sql, $usuario);