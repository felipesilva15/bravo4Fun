<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setId(isset($_POST["CATEGORIA_ID"]) ? $_POST["CATEGORIA_ID"] : 0);
$categoria->setNome(isset($_POST["CATEGORIA_NOME"]) ? $_POST["CATEGORIA_NOME"] : "");
$categoria->setDescricao(isset($_POST["CATEGORIA_DESC"]) ? $_POST["CATEGORIA_DESC"] : "");


$response = $categoria->update();

echo $response;

header('refresh: 3; url=categoriaConsultar.php');
