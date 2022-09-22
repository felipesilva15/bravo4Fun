<?php

// Extrai os dados do cookie do usuário
$userData = isset($_COOKIE["usrData"]) ? json_decode($_COOKIE["usrData"], true) : [];

// Define qual o destino do login
if(isset($userData["id"]) && $userData["id"] != 0 && $userData["id"] != null){
    header('Location: views/menu.html');
} else{
    header('Location: views/login.html');
}