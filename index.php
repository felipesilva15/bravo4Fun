<?php

error_reporting(E_ERROR | E_PARSE);

require_once("config.php");

$data = json_decode(validarCredenciais(), true); 

// Define qual o destino do login
if($data["status"] < 400){
    header('Location: views/menu.php');
} else{
    header('Location: views/login.html');
}