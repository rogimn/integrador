<?php
#phpinfo();
#ini_set('display_errors', 'On');
#error_reporting(E_ALL);

require_once 'config/Database.php';

$database = new Database();
#print_r($database);

print_r($database->getConnection());