<?php

require_once("config.php");


$fileStream = $_FILES["ARQUIVO"];

// var_dump($fileStream);
// return;

$files = new Files();

$files->setFile($fileStream);
$response = $files->uploadFile();

echo $response;

// $files->setFilePath("assets/859.png");
// $files->downloadFile();
