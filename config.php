<?php

// Seta a localidade
setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "portuguese");

// Realiza o auto carregamento das classes do projeto
spl_autoload_register(function($className){
    $classDir = "class";
    $filename = $classDir.DIRECTORY_SEPARATOR.$className.".php";

    if (file_exists($filename)){
        require_once($filename);
    }
});

require_once("sysFuncoes.php");


if (!isset($isLogin) || !$isLogin){
    $responseCredentials = json_decode(validarCredenciais(), true);

    if (!$responseCredentials["status"] || $responseCredentials["status"] == 403 ){
        echo json_encode($responseCredentials);
        return;
    }
}