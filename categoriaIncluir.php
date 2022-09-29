<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setNome($_POST["CATEGORIA_NOME"]);
$categoria->setDescricao($_POST["CATEGORIA_DESC"]);

try{
    $response = $categoria->insert();
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