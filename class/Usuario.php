<?php

//require_once("sysFuncoes.php");

class Usuario{
    private $id = 0, $nome = "", $email = "", $senha = ""; 

    public function getId():int{
        return($this->id);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome():string{
        return($this->nome);
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getSenha():string{
        return($this->senha);
    }

    public function setSenha($senha){
        $this->senha = sha1($senha);
    }

    public function getEmail():string{
        return($this->email);
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setData($data = []){
        $this->setId(isset($data["ADM_ID"]) ? $data["ADM_ID"] : 0);
        $this->setNome(isset($data["ADM_NOME"]) ? $data["ADM_NOME"] : "");
        $this->setEmail(isset($data["ADM_EMAIL"]) ? $data["ADM_EMAIL"] : "");
        $this->setSenha(isset($data["ADM_SENHA"]) ? $data["ADM_SENHA"] : "");
    }

    public function unsetData(){
        $this->setId(0);
        $this->setNome("");
        $this->setEmail("");
        $this->setSenha("");
    }

    public function getUsuarios(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR";

        $data = $sql->select($query);

        return($data);
    }

    public function loadById(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Usuário inválido!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"OK"]);
        }

        return($response);
    }

    public function login(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :EMAIL AND ADM_SENHA = :SENHA";
        $params = [
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Usuário e/ou senha inválido!"]);
        }else{
            $this->setId($data[0]["ADM_ID"]);
            $this->loadById();

            $response = json_encode(["status"=> 200, "message"=>"Conectado com sucesso!"]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $resValidar = $this->validarUsuario();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA) VALUES (:NOME, :EMAIL, :SENHA)";
        $params = [
            ":NOME"=>$this->getNome(),
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha(),
        ];

        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

        if($this->getId() == 0){
            $response = json_encode(["status"=> 500, "message"=>"Erro ao cadastrar o usuário!"]);
        }else{
            $this->loadById();

            $response = json_encode(["status"=> 200, "message"=>"OK"]);
        }

        return($response);
    }

    public function update(){
        $sql = new Sql();

        $resValidar = $this->validarUsuario();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "UPDATE ADMINISTRADOR SET ADM_NOME = :NOME, ADM_EMAIL = :EMAIL, ADM_SENHA = :SENHA WHERE ADM_ID = :ID";
        $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha()
        ];

        $sql->executeQuery($query, $params);
        $this->loadById();

        $response = json_encode(["status"=> 200, "message"=>"OK"]);
        
        return($response);
    }

    public function delete(){
        $sql = new Sql();

        $query = "DELETE FROM ADMINISTRADOR WHERE ADM_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        $sql->executeQuery($query, $params);

        $this->unsetData();
        $response = json_encode(["status"=> 200, "message"=>"OK"]);

        return($response);
    }

    public function validarUsuario(){
        $response = "";

        if(!isset($this->nome) || $this->nome == ""){
            $response = ["status"=> 400, "message"=>"Nome não informado!"];
        } elseif (!isset($this->email) || $this->email == "") {
            $response = ["status"=> 400, "message"=>"E-mail não informado!"];
        } elseif (!isset($this->senha) || $this->senha == ""){
            $response = ["status"=> 400, "message"=>"Senha não informada!"];
        } else{
            $response = ["status"=> 200, "message"=>"Ok"];
        }

        return($response);
    }

    public function __toString():string{
        return(json_encode([
            "ADM_ID"=>$this->getId(),
            "ADM_NOME"=>$this->getNome(),
            "ADM_EMAIL"=>$this->getEmail(),
            "ADM_SENHA"=>$this->getSenha()
        ]));
    }
}