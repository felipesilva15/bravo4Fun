<?php

require_once("config.php");

$produto = new Produto();

$produto->setId(isset($_POST["PRODUTO_ID"]) ? $_POST["PRODUTO_ID"] : 0);
$produto->setNome(isset($_POST["PRODUTO_NOME"]) ? $_POST["PRODUTO_NOME"] : "");
$produto->setDesc(isset($_POST["PRODUTO_DESC"]) ? $_POST["PRODUTO_DESC"] : "");
$produto->setCategoria(isset($_POST["CATEGORIA_ID"]) ? $_POST["CATEGORIA_ID"] : "");
$produto->setPreco(isset($_POST["PRODUTO_PRECO"]) ? $_POST["PRODUTO_PRECO"] : "");
$produto->setDesconto(isset($_POST["PRODUTO_DESCONTO"]) ? $_POST["PRODUTO_DESCONTO"] : "");

try{
    $response = $produto->update();
} catch (Exception $e) {
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}

$produtoEstoque = new ProdutoEstoque();

$produtoEstoque->setProduto($produto->getId());
$produtoEstoque->setQuantidade(isset($_POST["PRODUTO_QTD"]) ? $_POST["PRODUTO_QTD"] : 0);

if(json_decode($response, true)["status"] == 200){
    try{
        $response = $produtoEstoque->atualizarEstoque();
    } catch (Exception $e) {
        $response = json_encode([
            "status"=>500,
            "errorCode"=>$e->getCode(),
            "message"=>$e->getMessage(),
            "file"=>$e->getFile(),
            "line"=>$e->getLine()
        ]);
    }
}

echo $response;