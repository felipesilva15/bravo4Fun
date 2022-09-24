<?php

require_once("config.php");

$admin = new Usuario();

$admin->setNome($_POST["ADM_NOME"]);
$admin->setEmail($_POST["ADM_EMAIL"]);
$admin->setSenha($_POST["ADM_SENHA"]);

try{
    $response = $admin->insert();
} catch (Exception $e) {
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}

echo $response;