<?php

require_once("config.php");

$files = new Files();

$files->setFilePath(isset($_POST["LINKARQUIVO"]) ? $_POST["LINKARQUIVO"] : "");

try{
    $response = $files->downloadFile();
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
