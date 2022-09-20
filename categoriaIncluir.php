<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setNome($_POST["CATEGORIA_NOME"]);
$categoria->setDescricao($_POST["CATEGORIA_DESC"]);

$response = $categoria->insert();

echo $response;

header('refresh: 3; url=categoriaConsultar.php');