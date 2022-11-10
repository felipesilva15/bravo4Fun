<?php

//require_once("sysFuncoes.php");

class Usuario{
    private $id = 0, $nome = "", $email = "", $senha = "", $senhaConf = "", $ativo = 0; 

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

    public function getSenhaConf():string{
        return($this->senhaConf);
    }

    public function setSenhaConf($senhaConf){
        $this->senhaConf = sha1($senhaConf ?? "");
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
        $this->setAtivo(isset($data["ADM_ATIVO"]) ? $data["ADM_ATIVO"] : 1);
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
            $params[":NOME"] = "%{$this->getNome()}%";
        }
        if($this->getEmail() !== ""){
            $sqlWhere .= " AND ADM_EMAIL LIKE :EMAIL";
            $params[":EMAIL"] = "%{$this->getEmail()}%";
        }
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(ADM_ATIVO, 1) = 1";
        }

        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM ADMINISTRADOR $sqlWhere ORDER BY ADM_ID DESC";

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
            $response = json_encode(["status"=> 500, "title"=>"Administrador inválido", "message"=>"Não foi possível encontrar este administrador na base de dados", "items"=>[]]);
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
            $response = json_encode(["status"=> 403, "title"=>"Falha na autenticação", "message"=>"E-mail e/ou senha inválido.", "items"=>["showError"=>true]]);
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
            $response = json_encode(["status"=> 500, "title"=>"Erro inesperado", "message"=>"Ocorreu um erro ao cadastrar o usuário. Tente novamente mais tarde."]);
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
            if($this->validarAdminExistente()){
                $response = json_encode([
                    "status"=> 400, 
                    "title"=>"Dado inválido", 
                    "message"=>"Já existe um administrador cadastrado com este e-mail. Tente um e-mail diferente.",
                    "items"=>[]
                ]);
            }

            if(isset($response) && $response !== ""){
                return($response);
            }

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

        if($this->getNome() == ""){
            $response = ["status"=> 400, "title"=>"Dado inválido",  "message"=>"O campo de nome não foi preenchido."];
        } elseif ($this->getEmail() == "") {
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"O campo de e-mail não foi preenchido."];
        } elseif ($this->getSenha() == "" || $this->getSenha() == sha1("")){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"O campo de senha não foi preenchido."];
        } elseif (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Este e-mail não é válido."];
        } elseif ($this->getSenha() != $this->getSenhaConf()){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"As senhas informadas não condizem."];
        } elseif($this->validarAdminExistente()){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Já existe um administrador cadastrado com este e-mail. Tente um e-mail diferente."];
        } else{
            $response = ["status"=> 200, "title"=>"Dado inválido", "message"=>"Ok"];
        }

        return($response);
    }

    private function validarAdminExistente(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :EMAIL AND ADM_ID <> :ID AND COALESCE(ADM_ATIVO, 1) = 1";
        $params = [
            ":EMAIL"=>$this->getEmail(),
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        $adminRepetido = count($data) > 0 ? true : false; 

        return($adminRepetido);
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