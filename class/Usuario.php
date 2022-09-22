<?php

//require_once("sysFuncoes.php");

class Usuario{
    private $id = 0, $nome = "", $email = "", $senha = "", $ativo = 0; 

    public function getId():int{
        return($this->id);
    }

    public function setId($id){
        $this->id = $id ?? 0;
    }

    public function getNome():string{
        return($this->nome);
    }

    public function setNome($nome){
        $this->nome = $nome ?? "";
    }

    public function getSenha():string{
        return($this->senha);
    }

    public function setSenha($senha){
        $this->senha = sha1($senha ?? "");
    }

    public function getEmail():string{
        return($this->email);
    }

    public function setEmail($email){
        $this->email = $email ?? "";
    }

    public function setAtivo($ativo){
        $this->ativo = $ativo ?? 1;
    }

    public function getAtivo():int{
        return($this->ativo);
    }

    public function setData($data = []){
        $this->setId(isset($data["ADM_ID"]) ? $data["ADM_ID"] : 0);
        $this->setNome(isset($data["ADM_NOME"]) ? $data["ADM_NOME"] : "");
        $this->setEmail(isset($data["ADM_EMAIL"]) ? $data["ADM_EMAIL"] : "");
        $this->setSenha(isset($data["ADM_SENHA"]) ? $data["ADM_SENHA"] : "");
        $this->setAtivo(isset($data["ADM_ATIVO"]) ? $data["ADM_ATIVO"] : 0);
    }

    public function unsetData(){
        $this->setId(0);
        $this->setNome("");
        $this->setEmail("");
        $this->setSenha("");
        $this->setAtivo(0);
    }

    public function getUsuarios($exibirInativo = 0){
        $sql = new Sql();

        $sqlWhere = "";
        $params = [];

        if($this->getId() !== 0){
            $sqlWhere .= " AND ADM_ID = :ID";
            $params[":ID"] = $this->getId();
        }
        if($this->getNome() !== ""){
            $sqlWhere .= " AND ADM_NOME LIKE :NOME";
            $params[":NOME"] = "{$this->getNome()}%";
        }
        if($this->getEmail() !== ""){
            $sqlWhere .= " AND ADM_EMAIL LIKE :EMAIL";
            $params[":EMAIL"] = "{$this->getEmail()}%";
        }
        if($exibirInativo == 0){
            $sqlWhere .= " AND ADM_ATIVO = 1";
        }

        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM ADMINISTRADOR $sqlWhere";

        $data = $sql->select($query, $params);

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
            $response = json_encode(["status"=> 500, "message"=>"Usuário inválido!", "items"=>[]]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        }

        return($response);
    }

    public function login(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :EMAIL AND ADM_SENHA = :SENHA AND COALESCE(ADM_ATIVO, 1) = 1";
        $params = [
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Usuário e/ou senha inválido!", "items"=>[]]);
        }else{
            $this->setId($data[0]["ADM_ID"]);
            $this->loadById();

            $response = json_encode(["status"=> 200, "message"=>"Conectado com sucesso!", "items"=>[]]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $resValidar = $this->validarUsuario();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) VALUES (:NOME, :EMAIL, :SENHA, 1)";
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

            $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
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

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
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
        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);

        return($response);
    }

    public function desativar(){
        $sql = new Sql();

        $this->loadById();

        $query = "UPDATE ADMINISTRADOR SET ADM_ATIVO = :ATIVO WHERE ADM_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        if($this->getAtivo() == 0){
            $params[":ATIVO"] = 1;
        } else{
            $params[":ATIVO"] = 0;
        }

        $sql->executeQuery($query, $params);

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
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
            "ADM_SENHA"=>$this->getSenha(),
            "ADM_ATIVO"=>$this->getAtivo()
        ]));
    }
}