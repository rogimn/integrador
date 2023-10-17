<?php

if (isset($_GET['' . $cfg['qsmd5']['mes'] . ''])) {
    $mes = $_GET['' . $cfg['qsmd5']['mes'] . ''];
} else {
    $mes = date('m');
}

if (isset($_GET['left'])) {
    if ($mes == '12') {
        $ano = $_GET['' . $cfg['qsmd5']['ano'] . ''] - 1;
    } else {
        $ano = $_GET['' . $cfg['qsmd5']['ano'] . ''];
    }
}

if (isset($_GET['right'])) {
    if ($mes == '01') {
        $ano = $_GET['' . $cfg['qsmd5']['ano'] . ''] + 1;
    } else {
        $ano = $_GET['' . $cfg['qsmd5']['ano'] . ''];
    }
}

if (isset($_GET['pick'])) {
    $ano = $_GET['' . $cfg['qsmd5']['ano'] . ''];
}

if ((!isset($_GET['left'])) and (!isset($_GET['right'])) and (!isset($_GET['pick']))) {
    $ano = date('Y');
}

$mesleft = $mes - 1;
$mesright = $mes + 1;

if (strlen($mesleft) == 1) {
    $mesleft = '0' . $mesleft;

    if ($mesleft == '00') {
        $mesleft = '12';
    }
}

if (strlen($mesright) == 1) {
    $mesright = '0' . $mesright;

    if ($mesright == '13') {
        $mesright = '01';
    }
} else {
    if ($mesright == '13') {
        $mesright = '01';
    }
}