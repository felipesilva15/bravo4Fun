<?php

require_once("config.php");


$fileStream = $_FILES["archive"];

// var_dump($fileStream);
// return;

$files = new Files();

// $files->setFile($fileStream);
// $response = $files->uploadFile();

$files->setFilePath("assets/859.png");
$files->downloadFile();
