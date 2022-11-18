<?php

class Produto{
    private $id = 0, $nome = "", $ativo = 0, $desc = "", $categoria = 0, $preco = 0, $desconto = 0, $quantidade=0;
   
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

    public function getDesc():string{
        return($this->desc);
    }

    public function setDesc($desc){
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
    public function getQuantidade():int{
        return($this->quantidade);
    }    
    public function setQuantidade($quantidade){
        $this->quantidade = $quantidade ?? 0;
    }

    public function setData($data = []){
        $this->setId(isset($data["PRODUTO_ID"]) ? $data["PRODUTO_ID"] : 0);
        $this->setNome(isset($data["PRODUTO_NOME"]) ? $data["PRODUTO_NOME"] : "");
        $this->setDesc(isset($data["PRODUTO_DESC"]) ? $data["PRODUTO_DESC"] : "");
        $this->setCategoria(isset($data["CATEGORIA_ID"]) ? $data["CATEGORIA_ID"] : 0);
        $this->setPreco(isset($data["PRODUTO_PRECO"]) ? $data["PRODUTO_PRECO"] : 0);
        $this->setDesconto(isset($data["PRODUTO_DESCONTO"]) ? $data["PRODUTO_DESCONTO"] : 0);
        $this->setAtivo(isset($data["PRODUTO_ATIVO"]) ? $data["PRODUTO_ATIVO"] : 1);
        $this->setQuantidade(isset($data["PRODUTO_QTD"]) ? $data["PRODUTO_QTD"] : 0);
    }

    public function unsetData(){
        $this->setId(0);  
        $this->setNome("");     
        $this->setDesc(""); 
        $this->setCategoria(0);    
        $this->setPreco(0);
        $this->setDesconto(0);
        $this->setAtivo(0);
        $this->setQuantidade(0);
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
        if($this->getDesc() !== ""){
            $sqlWhere .= " AND PRODUTO_DESC LIKE :DESC";
            $params[":DESC"] = "%{$this->getDesc()}%";
        }
        if($this->getCategoria() !== ""){
            $sqlWhere .= " AND CATEGORIA_ID = :CATEGORIA";
            $params[":CATEGORIA"] = $this->getCategoria();
        }
       /* if($this->getPreco() !== ""){
            $sqlWhere .= " AND PRODUTO_PRECO LIKE :PRECO";
            $params[":PRECO"] = "%{$this->getPreco()}%";
        }
        if($this->getDesconto() !== ""){
            $sqlWhere .= " AND PRODUTO_DESCONTO LIKE :DESCONTO";
            $params[":DESCONTO"] = "%{$this->getDesconto()}%";
        }*/
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(PRODUTO_ATIVO, 1) = 1";
        }
        
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "  SELECT 
                        PRO.*, 
                        CAT.CATEGORIA_NOME, 
                        PE.PRODUTO_QTD
                    FROM PRODUTO PRO 
                    LEFT JOIN CATEGORIA CAT ON CAT.CATEGORIA_ID=PRO.CATEGORIA_ID 
                    LEFT JOIN PRODUTO_IMAGEM PIMG ON PIMG.PRODUTO_ID=PRO.PRODUTO_ID AND PIMG.IMAGEM_ORDEM=0
                    LEFT JOIN PRODUTO_ESTOQUE PE ON PE.PRODUTO_ID=PRO.PRODUTO_ID 
                    $sqlWhere  
                    ORDER BY 
                        PRODUTO_ID DESC";

        $data = $sql->select($query, $params);


        return($data);
    }

    public function loadById(){
        $sql = new Sql();
    
        $query = "SELECT PRO.*, EST.PRODUTO_QTD FROM PRODUTO PRO
                  LEFT JOIN PRODUTO_ESTOQUE EST ON EST.PRODUTO_ID = PRO.PRODUTO_ID
                  WHERE PRO.PRODUTO_ID = :ID";
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

        //Tratando valores       
        $preco = str_replace(',','.',$this->getPreco());
        $desconto = str_replace(',','.',$this->getDesconto());
     
        $params = [
             ":NOME"=>$this->getNome(),
             ":DESC"=>$this->getDesc(),
             ":PRECO"=>floatval($preco),
             ":DESCONTO"=>floatval($desconto),
             ":CATEGORIA"=>$this->getCategoria(),        
        ];
        
        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

        if($this->getId() == 0){
            $response = json_encode(["status"=> 500, "title"=>"Erro inesperado", "message"=>"Ocorreu um erro ao cadastrar o produto. Tente novamente mais tarde."]);
        }else{
            $this->updateEstoque();
            $this->loadById();
    
            $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        }

        return($response);
    }

    public function update(){
        $sql = new Sql();

        $resValidar = $this->validarProduto();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }
     
        $query = "  UPDATE PRODUTO 
                    SET PRODUTO_NOME = :NOME, PRODUTO_DESC = :DESC, PRODUTO_PRECO = :PRECO, PRODUTO_DESCONTO = :DESCONTO, CATEGORIA_ID = :CATEGORIA
                    WHERE PRODUTO_ID = :ID";
       
        //Tratando valores       
        $preco = str_replace(',','.',$this->getPreco());
        $desconto = str_replace(',','.',$this->getDesconto());

       $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":DESC"=>$this->getDesc(),
            ":PRECO"=>floatval($preco),
            ":DESCONTO"=>floatval($desconto),
            ":CATEGORIA"=>intval($this->getCategoria()),
        ];                  
           
        $sql->executeQuery($query, $params);
        $this->updateEstoque();

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }

    public function updateEstoque(){
        $sql = new Sql();
    
        $query = "SELECT * FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :ID";
        $params = [
            ":ID"=>$this->getId(),
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){           
            $query = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:ID, :QTD)";
        }else{            
            $query = "UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :QTD WHERE PRODUTO_ID = :ID";
        }        
                     
       $params = [
            ":ID"=>$this->getId(),
            ":QTD"=>$this->getQuantidade(),
        ];                  

        $sql->executeQuery($query, $params);

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }  

    public function desativar(){
        $sql = new Sql();

        $this->loadById();
 
        $query = "UPDATE PRODUTO SET PRODUTO_ATIVO = CAST(:ATIVO AS SIGNED) WHERE PRODUTO_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        if($this->getAtivo() == false){
            
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

    public function validarProduto(){
        $response = "";

        if(!isset($this->nome) || $this->nome == ""){
            $response = ["status"=> 400, "title"=>"Dado inválido",  "message"=>"O campo de nome do produto não foi preenchido."];
         } else{
            $response = ["status"=> 200, "title"=>"Dado válido", "message"=>"Ok"];
        }

        return($response);
    }

    private function validarProdutoExistente(){
        $sql = new Sql();

        $query = "SELECT * FROM PRODUTO WHERE PRODUTO_NOME = :NOME AND COALESCE(PRODUTO_ATIVO, 1) = 1 AND PRODUTO_ID <> :ID";
        $params = [
            ":NOME"=>$this->getNome(),
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        $produtoRepetido = count($data) > 0 ? true : false; 

        return($produtoRepetido);
    }
    public function __toString():string{
        return(json_encode([
            "PRODUTO_ID"=>$this->getId(),    
            "PRODUTO_NOME"=>$this->getNome(), 
            "PRODUTO_DESC"=>$this->getDesc(),        
            "PRODUTO_PRECO"=>$this->getPreco(),        
            "PRODUTO_DESCONTO"=>$this->getDesconto(),                    
            "PRODUTO_CATEGORIA"=>$this->getCategoria(),                    
            "PRODUTO_ATIVO"=>$this->getAtivo()
        ]));
    }
}