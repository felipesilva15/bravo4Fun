<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->unsetData();

$usuario->setNome($_POST["ADM_NOME"]);
$usuario->setEmail($_POST["ADM_EMAIL"]);
$usuario->setSenha($_POST["ADM_SENHA"]);

$response = $usuario->insert();

echo $response;

header('refresh: 3; url=views/login.html');