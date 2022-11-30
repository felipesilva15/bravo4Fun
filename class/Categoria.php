<?php

//require_once(".php");

class Categoria{
    private $id = 0, $nome = "", $descricao = "", $ativo = 0;

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

    public function getAtivo():int{
        return($this->ativo);
    }

    public function setAtivo($ativo){
        $this->ativo = $ativo ?? 1;
    }

    public function setData($data = []){
        $this->setId(isset($data["CATEGORIA_ID"]) ? $data["CATEGORIA_ID"] : 0);
        $this->setNome(isset($data["CATEGORIA_NOME"]) ? $data["CATEGORIA_NOME"] : "");
        $this->setDescricao(isset($data["CATEGORIA_DESC"]) ? $data["CATEGORIA_DESC"] : "");
        $this->setAtivo(isset($data["CATEGORIA_ATIVO"]) ? $data["CATEGORIA_ATIVO"] : 1);
    }

    public function unsetData(){
        $this->setId(0);
        $this->setNome("");
        $this->setDescricao("");
        $this->setAtivo(0);
    }

    public function getCategorias($exibirInativo = 0){
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
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(CATEGORIA_ATIVO, 1) = 1";
        }
        
        //Esse bloco é para limitar a quantidades de dados a ser digitado pelo usuário?
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM CATEGORIA $sqlWhere ORDER BY CATEGORIA_ID DESC";

        $data = $sql->select($query, $params);

        return($data);
    }

    public function loadById(){
        $sql = new Sql();

        $query = "SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Categoria inválida!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $resValidar = $this->validarCategoria();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC) VALUES (:NOME, :DESCRICAO)";
        $params = [
            ":NOME"=>$this->getNome(),
            ":DESCRICAO"=>$this->getDescricao(),
        ];

        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

            if($this->getId() == 0){
                $response = json_encode(["status"=> 500, "message"=>"Erro ao cadastrar categoria!"]);
            }else{
                $this->loadById();

                $response = json_encode(["status"=> 200, "message"=>"Categoria Inclusa", "items"=>[]]);
            }

        return($response); 
    }

    public function update(){
        $sql = new Sql();

        $resValidar = $this->validarCategoria();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "UPDATE CATEGORIA SET CATEGORIA_NOME = :NOME, CATEGORIA_DESC = :DESCRICAO WHERE CATEGORIA_ID = :ID";
        $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":DESCRICAO"=>$this->getDescricao(),
        ];

        $sql->executeQuery($query, $params);
        $this->loadById();

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
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
        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);

        return($response);
    }

    public function desativar(){
        $sql = new Sql();

        $this->loadById();

        $query = "UPDATE CATEGORIA SET CATEGORIA_ATIVO = CAST(:ATIVO AS SIGNED) WHERE CATEGORIA_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        if($this->getAtivo() == 0){
            if($this->validarCategoriaExistente()){
                $response = json_encode([
                    "status"=> 400, 
                    "title"=>"Alteração não permitida", 
                    "message"=>"Já existe uma Categoria cadastrada com este nome.",
                    "items"=>[]
                ]);
            }

            $params[":ATIVO"] = 1;
        } else{
            
            if($this->validarProdutoVinculadoCategoria()){
                $response = json_encode([
                    "status"=> 400, 
                    "title"=>"Alteração não permitida", 
                    "message"=>"Não é possível desativar categoria pois existem produtos vinculados a ela.",
                    "items"=>[]
                ]);
            }

            $params[":ATIVO"] = 0;
        }

        if(isset($response) && $response !== ""){
            return($response);
        }
        
        $sql->executeQuery($query, $params);

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }

    public function validarCategoria(){
        $response = "";

        if(!isset($this->nome) || $this->nome == ""){
            $response = ["status"=> 400, "title"=>"Dado inválido",  "message"=>"O campo de nome da Categoria não foi preenchido."];
        } elseif (!isset($this->descricao) || $this->descricao == "") {
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Para cadastrar uma categoria você precisa inserir uma Descrição."];
        } elseif($this->validarCategoriaExistente()){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Já existe uma Categoria cadastrada com este nome."];
        } else{
            $response = ["status"=> 200, "title"=>"Dado inválido", "message"=>"Ok"];
        }

        return($response);
    }

    private function validarCategoriaExistente(){
        $sql = new Sql();

        $query = "SELECT * FROM CATEGORIA WHERE CATEGORIA_NOME = :NOME AND COALESCE(CATEGORIA_ATIVO, 1) = 1 AND CATEGORIA_ID <> :ID";
        $params = [
            ":NOME"=>$this->getNome(),
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        $categoriaRepetida = count($data) > 0 ? true : false; 

        return($categoriaRepetida);
    }

    private function validarProdutoVinculadoCategoria(){
        $sql = new Sql();

        $query = "SELECT PRO.PRODUTO_ID FROM PRODUTO PRO WHERE PRO.CATEGORIA_ID = :CATEGORIA AND COALESCE(PRO.PRODUTO_ATIVO, 1) = 1";
        $params = [
            ":CATEGORIA"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        $categoriaExistente = count($data) > 0 ? true : false; 

        return($categoriaExistente);
    }

    public function __toString():string{
        return(json_encode([
            "CATEGORIA_ID"=>$this->getId(),
            "CATEGORIA_NOME"=>$this->getNome(),
            "CATEGORIA_DESC"=>$this->getDescricao(),
            "CATEGORIA_ATIVO"=>$this->getAtivo()
        ]));
    }
}