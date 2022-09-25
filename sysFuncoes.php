<?php

function trataValor($valor, $tipo){
    switch ($tipo){
        case "B":
            $retorno = gettype($valor) == "boolean" ? $valor : false;
            break;

        case "I":
            $retorno = gettype($valor) == "integer" ? $valor : 0;
            break;

        case "N":
            $retorno = gettype($valor) == "double" ? $valor : 0.00;
            break;

        case "S":
            $retorno = gettype($valor) == "string" ? $valor : "";
            break;

        case "A":
            $retorno = gettype($valor) == "array" ? $valor : [];
            break;

        case "D":
            $retorno = gettype($valor) == "object" ? $valor : new DateTime();
            break;
        
        default:
            $retorno = false;
            break;
    }

    return($retorno);
}

function validarCredenciais():string{
    // Extrai os dados do cookie do usuário
    $userData = isset($_COOKIE["usrData"]) ? json_decode($_COOKIE["usrData"], true) : [];

    // Define qual o destino do login
    if(isset($userData["id"]) && $userData["id"] != 0 && $userData["id"] != null){
        return (json_encode([
            "status"=>200,
            "message"=>"Ok",
            "items"=>[]
        ]));
    } else{
        return (json_encode([
            "status"=>403,
            "message"=>"Usuário não autenticado! Faça login novamente.",
            "items"=>[]
        ]));
    }
}