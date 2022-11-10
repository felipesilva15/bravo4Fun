<?php

require_once("config.php");

//unset($_COOKIE["usrData"]);
setcookie("usrData", null, -1);

echo json_encode([
    "status"=>200,
    "message"=>"OK",
    "items"=>[]
]);