<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setId(isset($_POST["CATEGORIA_ID"]) ? $_POST["CATEGORIA_ID"] : 0);
$categoria->setNome(isset($_POST["CATEGORIA_NOME"]) ? $_POST["CATEGORIA_NOME"] : "");
$categoria->setDescricao(isset($_POST["CATEGORIA_DESC"]) ? $_POST["CATEGORIA_DESC"] : "");

try{
$response = $categoria->update();
} catch (Exception $e){
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}
echo $response;