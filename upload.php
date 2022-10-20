<?php

require_once("config.php");

try{
    $fileStream = $_FILES["ARQUIVO"];

    $files = new Files();

    $files->setFile($fileStream);
    $response = $files->uploadFile();
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
