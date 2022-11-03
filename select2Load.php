<?php

require_once("config.php");

$configName = isset($_GET["select2ConfigName"]) ? $_GET["select2ConfigName"] : "";
$command = getSelect2Command($configName);

try{
    $sql = new Sql();

    $data = $sql->select($command);

    $response = json_encode([
        "status"=>200,
        "message"=>"OK",
        "items"=>[$data]
    ]);
} catch (Exception $e){
    $response = json_encode([
        "status"=>500,
        "errorCode"=>$e->getCode(),
        "message"=>$e->getMessage(),
        "file"=>$e->getFile(),
        "line"=>$e->getLine()
    ]);
}

echo $response;