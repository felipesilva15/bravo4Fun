<?php

require_once("config.php");

error_reporting(E_ERROR | E_PARSE);

//unset($_COOKIE["usrData"]);
setcookie("usrData", "", -1);

echo json_encode([
    "status"=>200,
    "message"=>"OK",
    "items"=>[]
]);