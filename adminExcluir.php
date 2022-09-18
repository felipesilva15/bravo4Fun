<?php

require_once("config.php");

$admin = new Usuario();

$admin->setId($_GET["id"]);

$response = $admin->delete();

echo $response;

header('refresh: 3; url=adminConsultar.php');