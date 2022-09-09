<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->unsetData();

$usuario->setNome($_POST["ADM_NOME"]);
$usuario->setEmail($_POST["ADM_EMAIL"]);
$usuario->setSenha($_POST["ADM_SENHA"]);

$usuario->insert();

echo $usuario;