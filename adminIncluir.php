<?php

require_once("config.php");

$admin = new Usuario();

$admin->setNome($_POST["ADM_NOME"]);
$admin->setEmail($_POST["ADM_EMAIL"]);
$admin->setSenha($_POST["ADM_SENHA"]);

$response = $admin->insert();

echo $response;

header('refresh: 3; url=adminConsultar.php');