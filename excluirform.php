<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->setId($_GET["id"]);

$response = $usuario->delete();

echo $response;