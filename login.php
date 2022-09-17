<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->setEmail($_POST["ADM_EMAIL"]);
$usuario->setSenha($_POST["ADM_SENHA"]);

$response = json_decode($usuario->login(), true);

if (isset($response["status"]) && $response["status"] == 200){
    $userData = [
        "id"=>$usuario->getId(),
        "nome"=>$usuario->getNome()
    ];

    // Define cookie do usuário com vencimento em 1 hora
    setcookie("usr_data", json_encode($userData), time() + 3600);

    header('Location: views/menu.html');
} else{
    echo $response["message"];
    header('refresh: 3; url=views/login.html');
}