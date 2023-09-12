<?php
spl_autoload_register(
    function (string $className) {
        #echo $className . '<br>';
        $fullPath = str_replace('Rogim\\Integrador', '.', $className);
        #echo $fullPath . '<br>';
        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $fullPath);
        #echo $filePath  . '<br>';
        $filePath .= '.php';
        #echo $filePath  . '<br>';
        
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
);