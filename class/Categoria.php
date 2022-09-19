<?php

//require_once(".php");

class Categoria{
    private $id = 0, $nome = "", $descricao = "";

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

    public function getDescricao():string{
        return($this->descricao);
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

    public function setData($data = []){
        $this->setId(isset($data["CATEGORIA_ID"]) ? $data["CATEGORIA_ID"] : 0);
        $this->setNome(isset($data["CATEGORIA_NOME"]) ? $data["CATEGORIA_NOME"] : "");
        $this->setDescricao(isset($data["CATEGORIA_DESC"]) ? $data["CATEGORIA_DESC"] : "");
    }

    public function unsetData(){
        $this->setId(0);
        $this->setNome("");
        $this->setDescricao("");
    }

    public function getCategorias(){
        $sql = new Sql();

        $sqlWhere = "";
        $params = [];

        if($this->getId()!== 0){
            $sqlWhere .= " AND CATEGORIA_ID = :ID";
            $params[":ID"] = $this->getId();
        }
        
        if($this->getNome() !== ""){
            $sqlWhere .= " AND CATEGORIA_NOME LIKE :NOME";
            $params[":NOME"] = "{$this->getNome()}%";
        }
        
        //Esse bloco aqui é para limitar a quantidades de dados a ser digitado pelo usuário?
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM CATEGORIA $sqlWhere";

        $data = $sql->select($query, $params);

        return($data);
    }

    public function loadById(){
        $sql = new Sql();

        $query = "SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :ID";
        $params = [
            ":ID"=>$this->getId();
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Categoria inválida!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"OK"]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $query = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC) VALUES (:NOME, :DESCRICAO)";
        $params = [
            ":NOME"=>$this->getNome(),
            ":DESCRICAO"=>$this->getDescricao()
        ];

        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

            if($this->getId() == 0){
                $response = json_encode(["status"=> 500, "message"=>"Erro ao cadastrar categoria!"]);
            }else{
                $this->loadById();

                $response = json_encode(["status"=> 200, "message"=>"Categoria Inclusa"])
            }

        return($response); 
    }

        public function update(){
            $sql = new Sql();
    
            $query = "UPDATE CATEGORIA SET CATEGORIA_NOME = :NOME, CATEGORIA_DESC = :DESCRICAO WHERE CATEGORIA_ID = :ID";
            $params = [
                ":ID"=>$this->getId(),
                ":NOME"=>$this->getNome(),
                ":DESCRICAO"=>$this->getDescricao(),
            ];
    
            $sql->executeQuery($query, $params);
            $this->loadById();
    
            $response = json_encode(["status"=> 200, "message"=>"OK"]);
            
            return($response);
        }

        public function delete(){
            $sql = new Sql();
    
            $query = "DELETE FROM CATEGORIA WHERE CATEGORIA_ID = :ID";
            $params = [
                ":ID"=>$this->getId()
            ];
    
            $sql->executeQuery($query, $params);
    
            $this->unsetData();
            $response = json_encode(["status"=> 200, "message"=>"OK"]);
    
            return($response);
        }
}