<?php

require_once("config.php");

$produto = new Produto();

$produto->setId($_GET["id"]);

try{
    $response = $produto->desativar();
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