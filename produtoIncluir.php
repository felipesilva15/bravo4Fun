<?php

require_once("config.php");

$produto = new Produto();

$produto->setNome(isset($_POST["PRODUTO_NOME"]) ? $_POST["PRODUTO_NOME"] : "");
$produto->setDesc(isset($_POST["PRODUTO_DESC"]) ? $_POST["PRODUTO_DESC"] : "");
$produto->setCategoria(isset($_POST["CATEGORIA_ID"]) ? $_POST["CATEGORIA_ID"] : 0);
$produto->setPreco(isset($_POST["PRODUTO_PRECO"]) ? $_POST["PRODUTO_PRECO"] : "");
$produto->setDesconto(isset($_POST["PRODUTO_DESCONTO"]) ? $_POST["PRODUTO_DESCONTO"] : "");
$produto->setQuantidade(isset($_POST["PRODUTO_QTD"]) ? $_POST["PRODUTO_QTD"] : "");

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