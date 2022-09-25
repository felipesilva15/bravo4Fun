<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->setEmail(isset($_POST["ADM_EMAIL"]) ? $_POST["ADM_EMAIL"] : "");
$usuario->setSenha(isset($_POST["ADM_SENHA"]) ? $_POST["ADM_SENHA"] : "");

$response = json_decode($usuario->login(), true);

if (isset($response["status"]) && $response["status"] == 200){
    $userData = [
        "id"=>$usuario->getId(),
        "nome"=>$usuario->getNome()
    ];

    // Define cookie do usuário com vencimento em 24 horas
    setcookie("usrData", json_encode($userData), time() + 86400);
} 

echo json_encode($response);