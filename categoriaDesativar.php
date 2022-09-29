<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setId($_GET["id"]);

try{
    $response = $categoria->desativar();
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