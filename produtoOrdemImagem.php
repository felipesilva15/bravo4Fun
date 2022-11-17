<?php

require_once("config.php");

$produtoImagem = new ProdutoImagem();

$produtoImagem->setProduto(isset($_POST["PRODUTO_ID"]) ? intval($_POST["PRODUTO_ID"]) : 0);
$produtoImagem->setImagens(isset($_POST["IMAGENS"]) ? $_POST["IMAGENS"] : []);

try{
    $response = $produtoImagem->atualizarImagens();
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