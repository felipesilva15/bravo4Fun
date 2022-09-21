<?php

require_once("config.php");

$categoria = new Categoria();

$categoria->setId($_GET["id"]);

$response = $categoria->delete();

echo $response;

header('refresh: 3; url=categoriaConsultar.php');