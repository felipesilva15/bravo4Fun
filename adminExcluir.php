<?php

require_once("config.php");

$admin = new Usuario();

$admin->setId($_GET["id"]);

try {
    $response = $admin->delete();
} catch (Exception $e) {
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}

echo $response;

header('refresh: 3; url=adminConsultar.php');