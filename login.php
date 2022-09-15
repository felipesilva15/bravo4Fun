<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->setEmail($_POST["ADM_EMAIL"]);
$usuario->setSenha($_POST["ADM_SENHA"]);

$response = $usuario->login();

echo $response;

header('refresh: 3; url=views/login.html');

