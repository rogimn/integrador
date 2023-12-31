<?php

#ini_set('display_errors', 'On');
#ini_set('output_buffering', 4096);
#ini_set('session.auto_start', 1);
#ini_set('SMTP', 'smtp.server.com');
#ini_set('smtp_port', 587);

#error_reporting(0);

session_start();

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_MONETARY, 'pt_BR');

$cfg = [
    'lang' => 'pt-br',
    'header' => [
        'title' => 'Integrador II - ',
        'subtitle' => [
            '404' => '404',
            '500' => '500',
            'install' => 'Instala&ccedil;&atilde;o',
            'index' => 'Entrar',
            'home' => 'In&iacute;cio',
            'user' => 'Usu&aacute;rios',
            'school' => 'Escolas',
            'person' => 'Pessoas',
            'delivery' => 'Entregas',
            'note' => 'Notas'
        ],
    ],
    'login_title' => 'Integrador&nbsp;<strong>II</strong>',
    'side_title' => 'Integrador&nbsp;II',
    'enigma' => 'Pw==', // char "?" on base_64 
    'input_required' => 'Campo obrigat&oacute;rio vazio.',
    'var_required' => 'Vari&aacute;vel de controle nula.',
    'invalid_email' => 'O formato do e-mail &eacute; inv&aacute;lido.',
    'no_encrypt_access' => 'N&atilde;o foi poss&iacute;vel criptografar o acesso.',
    'error' => [
        'title' => 'Erro!',
        'msg' => 'O registro selecionado n&atilde;o foi encontrado.'
    ],
    'id' => [
        'usuario' => '78eafd55d38a6cdcf6611ca998b01e44',
        'escola' => '2a0da8ad06a96827787ed16254376d10',
        'pessoa' => '5b9f3257ab6a7a150f20f7d4f228559b',
        'nota' => 'e94d72b183558d0cd1c4cf263f235560',
        'entrega' => 'aaeb7cc9d48f6cb5588cc5cbbcd9ed10',
        'log' => '48b1ffa07ea3b13ee31dd0de1596c594'
    ],
    'qsmd5' => [
        'dia' => '465b1f70b50166b6d05397fca8d600b0',
        'mes' => 'd2db8a610f8c7c0785d2d92a6e8c450e',
        'ano' => 'bde9dee6f523d6476dcca9cae8caa5f5',
        'report' => 'e98d2f001da5678b39482efbdf5770dc'
    ],
    'msg_empty_table' => [
        'title' => 'Nada encontrado!',
        'msg' => 'Nenhum registro cadastrado.'
    ],
    'print' => [
        'business_name' => 'Instituto Federal Catarinense',
        'address' => 'Rua Joaquim Garcia, s/c',
        'location' => '88340-055, Cambori&uacute;, SC',
        'phone' => '(47)2104-0800',
        'email' => 'gabinete.camboriu@ifc.edu.br'
    ]
];

// FUNÇÕES

/**
 * verifica se a sessão está ativa
 * @return bool
**/
function is_session_started()
{
    if (php_sapi_name() !== 'cli') {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }

    return FALSE;
}

/**
 * função que gera um código único
 * @return string
**/
function createCode()
{
    if (PHP_VERSION >= 7) {
        $bytes = random_bytes(5);
        $bytes = strtoupper(bin2hex($bytes));
    } else {
        $bytes = openssl_random_pseudo_bytes(ceil(20 / 2));
        $bytes = strtoupper(substr(bin2hex($bytes), 10));
    }

    return $bytes;
}

/**
 * função que realiza criptografia usando openssl
 * @return string
**/
function encrypt($data, $key)
{
    $len = strlen($key);

    if ($len < 16) {
        $key = str_repeat($key, ceil(16 / $len));
        $m = strlen($data) % 8;
        $data .= str_repeat("\x00", 8 - $m);
        $val = openssl_encrypt($data, 'AES-256-OFB', $key, 0, $key);
        $blow = base64_encode($val);
    } else {
        die('N&atilde;o foi poss&iacute;vel criptografar o acesso.');
    }

    return $blow;
}

/**
 * função que realiza descriptografia usando openssl
 * @return string
**/
function decrypt($data, $key)
{
    $len = strlen($key);

    if ($len < 16) {
        $key = str_repeat($key, ceil(16 / $len));
        $data = base64_decode($data);
        $val = openssl_decrypt($data, 'AES-256-OFB', $key, 0, $key);
        $unblow = str_replace(' ', '', $val);
    } else {
        die('N&atilde;o foi poss&iacute;vel descriptografar o acesso.');
    }

    return $unblow;
}

/**
 * função que retorna o mês por extenso
 * @return string
**/
function mes_extenso($fmes) {
    switch ($fmes) {
        case '01': $fmes = 'Janeiro'; break;
        case '02': $fmes = 'Fevereiro'; break;
        case '03': $fmes = 'Mar&ccedil;o'; break;
        case '04': $fmes = 'Abril'; break;
        case '05': $fmes = 'Maio'; break;
        case '06': $fmes = 'Junho'; break;
        case '07': $fmes = 'Julho'; break;
        case '08': $fmes = 'Agosto'; break;
        case '09': $fmes = 'Setembro'; break;
        case '10': $fmes = 'Outubro'; break;
        case '11': $fmes = 'Novembro'; break;
        case '12': $fmes = 'Dezembro'; break;
    }

    return $fmes;
}