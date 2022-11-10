<?php

require_once("config.php");

$produto = new Produto();

$produto->setNome(isset($_POST["PRODUTO_NOME"]) ? $_POST["PRODUTO_NOME"] : "");
$produto->setDescricao(isset($_POST["PRODUTO_DESC"]) ? $_POST["PRODUTO_DESC"] : "");
$produto->setCategoria(isset($_POST["CATEGORIA_NOME"]) ? $_POST["CATEGORIA_NOME"] : "");
$produto->setPreco(isset($_POST["PRODUTO_PRECO"]) ? $_POST["PRODUTO_PRECO"] : "");
$produto->setDesconto(isset($_POST["PRODUTO_DESCONTO"]) ? $_POST["PRODUTO_DESCONTO"] : "");

try{
    $response = $produto->insert();
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