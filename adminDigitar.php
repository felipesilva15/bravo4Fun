<?php

require_once("config.php");

$admin = new Usuario();

$admin->setId(isset($_GET["ADM_ID"]) ? $_GET["ADM_ID"] : 0);

try{
    $admin->loadById();
} catch (Exception $e) {
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}

echo $admin;