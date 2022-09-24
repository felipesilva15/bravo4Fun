<?php

require_once("config.php");

$admin = new Usuario();

$admin->setId(isset($_POST["ADM_ID"]) ? $_POST["ADM_ID"] : 0);
$admin->setNome(isset($_POST["ADM_NOME"]) ? $_POST["ADM_NOME"] : "");
$admin->setEmail(isset($_POST["ADM_EMAIL"]) ? $_POST["ADM_EMAIL"] : "");
$admin->setSenha(isset($_POST["ADM_SENHA"]) ? $_POST["ADM_SENHA"] : "");

try{
    $response = $admin->update();
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
