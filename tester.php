<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/*session_start();

echo 'status: ' . session_status() . '<br>';
echo 'id: ' . session_id()  . '<br>';

session_unset();
session_destroy();

echo 'status: ' . session_status() . '<br>';
echo 'id: ' . session_id();*/

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if (is_session_started() === FALSE) {
    session_start();
    echo 'status: ' . session_status() . '<br>';
    echo 'id: ' . session_id()  . '<br>';
}