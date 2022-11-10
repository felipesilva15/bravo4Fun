<?php

class Produto{
    private $id = 0, $nome = "", $ativo = 0, $desc = "", $categoria = 0, $preco = 0, $desconto = 0;
   
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
        return($this->desc);
    }

    public function setDescricao($desc){
        $this->desc = $desc ?? "";
    }
    public function getPreco():string{
        return($this->preco);
    }
    public function setPreco($preco){
        $this->preco = $preco ?? 0;
    }
    public function getDesconto():string{
        return($this->desconto);
    }
    public function setDesconto($desconto){
        $this->desconto = $desconto ?? 0;
    }
    public function getCategoria():string{
        return($this->categoria);
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria ?? 0;
    }

    public function getAtivo():int{
        return($this->ativo);
    }

    public function setAtivo($ativo){
        $this->ativo = $ativo ?? 1;
    }

    public function setData($data = []){
        $this->setId(isset($data["PRODUTO_ID"]) ? $data["PRODUTO_ID"] : 0);
        $this->setNome(isset($data["PRODUTO_NOME"]) ? $data["PRODUTO_NOME"] : "");
        $this->setDescricao(isset($data["PRODUTO_DESC"]) ? $data["PRODUTO_DESC"] : "");
        $this->setCategoria(isset($data["CATEGORIA_ID"]) ? $data["CATEGORIA_ID"] : 0);
        $this->setPreco(isset($data["PRODUTO_PRECO"]) ? $data["PRODUTO_PRECO"] : 0);
        $this->setDesconto(isset($data["PRODUTO_DESCONTO"]) ? $data["PRODUTO_DESCONTO"] : 0);
        $this->setAtivo(isset($data["PRODUTO_ATIVO"]) ? $data["PRODUTO_ATIVO"] : 1);
    }

    public function unsetData(){
        $this->setId(0);  
        $this->setNome("");     
        $this->setDescricao(""); 
        $this->setCategoria(0);    
        $this->setPreco(0);
        $this->setDesconto(0);
        $this->setAtivo(0);
    }

    public function getProdutos($exibirInativo = 0){
        $sql = new Sql();

        $sqlWhere = "";
        $params = [];

        if($this->getId()!== 0){
            $sqlWhere .= " AND PRODUTO_ID = :ID";
            $params[":ID"] = $this->getId();
        }       
        if($this->getNome() !== ""){
            $sqlWhere .= " AND PRODUTO_NOME LIKE :NOME";
            $params[":NOME"] = "%{$this->getNome()}%";
        }
        if($this->getDescricao() !== ""){
            $sqlWhere .= " AND PRODUTO_DESC LIKE :DESC";
            $params[":DESC"] = "%{$this->getDescricao()}%";
        }
        if($this->getCategoria() !== ""){
            $sqlWhere .= " AND CATEGORIA_ID LIKE :CATEGORIA";
            $params[":CATEGORIA"] = "%{$this->getCategoria()}%";
        }
        if($this->getPreco() !== ""){
            $sqlWhere .= " AND PRODUTO_PRECO LIKE :PRECO";
            $params[":PRECO"] = "%{$this->getPreco()}%";
        }
        if($this->getDesconto() !== ""){
            $sqlWhere .= " AND PRODUTO_DESCONTO LIKE :DESCONTO";
            $params[":DESCONTO"] = "%{$this->getDesconto()}%";
        }
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(PRODUTO_ATIVO, 1) = 1";
        }
        
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT PRO.*, CATEGORIA_NOME FROM PRODUTO PRO LEFT JOIN CATEGORIA CAT ON CAT.CATEGORIA_ID=PRO.CATEGORIA_ID $sqlWhere  ORDER BY PRODUTO_ID DESC";
        $data = $sql->select($query, $params);

        return($data);
    }

    public function loadById(){
        $sql = new Sql();

        $query = "SELECT * FROM PRODUTO WHERE PRODUTO_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Produto inválido!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $resValidar = $this->validarProduto();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) VALUES (:NOME, :DESC, :PRECO, :DESCONTO, :CATEGORIA, 1)";
        $params = [
            ":NOME"=>$this->getNome(),
            ":DESC"=>$this->getDescricao(),
            ":PRECO"=>$this->getPreco(),
            ":DESCONTO"=>$this->getDesconto(),
            ":CATEGORIA"=>$this->getCategoria(),
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
       // $sql = new Sql();

       // $resValidar = $this->validarProduto();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "  UPDATE PRODUTO 
                    SET PRODUTO_NOME = :NOME, PRODUTO_DESC = :DESC, PRODUTO_PRECO = :PRECO, PRODUTO_DESCONTO = :DESCONTO, CATEGORIA_ID = :CATEGORIA 
                    WHERE PRODUTO_ID = :ID";
        $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":DESC"=>$this->getDescricao(),
            ":PRECO"=>$this->getPreco(),
            ":DESCONTO"=>$this->getDesconto(),
            ":CATEGORIA"=>$this->getCategoria(),
        ];

        $sql->executeQuery($query, $params);

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }

    public function desativar(){
        $sql = new Sql();

        $this->loadById();

        $query = "UPDATE PRODUTO SET PRODUTO_ATIVO = :ATIVO WHERE PRODUTO_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        if($this->getAtivo() == 0){
            
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

    public function __toString():string{
        return(json_encode([
            "PRODUTO_ID"=>$this->getId(),    
            "PRODUTO_NOME"=>$this->getNome(), 
            "PRODUTO_DESC"=>$this->getDescricao(),        
            "PRODUTO_PRECO"=>$this->getPreco(),        
            "PRODUTO_DESCONTO"=>$this->getDesconto(),                    
            "PRODUTO_ATIVO"=>$this->getAtivo()
        ]));
    }
}