<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->setId($_POST["ADM_ID"]);
$usuario->setNome($_POST["ADM_NOME"]);
$usuario->setEmail($_POST["ADM_EMAIL"]);
$usuario->setSenha($_POST["ADM_SENHA"]);

$response = $usuario->update();

echo $response;

header('refresh: 3; url=listarAdmin.php');