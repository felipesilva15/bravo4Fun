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

    public function setData($data = []){
        $this->setId(isset($data["PRODUTO_ID"]) ? $data["PRODUTO_ID"] : 0);
        $this->setNome(isset($data["PRODUTO_NOME"]) ? $data["PRODUTO_NOME"] : "");
        $this->setDesc(isset($data["PRODUTO_DESC"]) ? $data["PRODUTO_DESC"] : "");
        $this->setCategoria(isset($data["CATEGORIA_ID"]) ? $data["CATEGORIA_ID"] : 0);
        $this->setPreco(isset($data["PRODUTO_PRECO"]) ? $data["PRODUTO_PRECO"] : 0);
        $this->setDesconto(isset($data["PRODUTO_DESCONTO"]) ? $data["PRODUTO_DESCONTO"] : 0);
        $this->setAtivo(isset($data["PRODUTO_ATIVO"]) ? $data["PRODUTO_ATIVO"] : 1);
    }

    public function unsetData(){
        $this->setId(0);  
        $this->setNome("");     
        $this->setDesc(""); 
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
            $sqlWhere .= " AND PRO.PRODUTO_ID = :ID";
            $params[":ID"] = $this->getId();
        }       
        if($this->getNome() !== ""){
            $sqlWhere .= " AND PRO.PRODUTO_NOME LIKE :NOME";
            $params[":NOME"] = "%{$this->getNome()}%";
        }
        if($this->getCategoria() != 0){
            $sqlWhere .= " AND PRO.CATEGORIA_ID = :CATEGORIA";
            $params[":CATEGORIA"] = $this->getCategoria();
        }
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(PRODUTO_ATIVO, 1) = 1";
        }
        
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "  SELECT 
                        PRO.*, 
                        COALESCE(CAT.CATEGORIA_NOME, '') AS CATEGORIA_NOME, 
                        COALESCE((
                            SELECT 
                                IMGAUX.IMAGEM_URL 
                            FROM PRODUTO_IMAGEM IMGAUX 
                            WHERE 
                                    IMGAUX.PRODUTO_ID = PRO.PRODUTO_ID 
                                AND IMGAUX.IMAGEM_ORDEM >= 0 
                            ORDER BY 
                                IMGAUX.IMAGEM_ORDEM 
                            LIMIT 1), '') AS IMAGEM_URL,
                        COALESCE(EST.PRODUTO_QTD, 0) AS PRODUTO_QTD,
                        COALESCE(PRO.PRODUTO_PRECO, 0) - COALESCE(PRO.PRODUTO_DESCONTO) AS PRODUTO_PRETOT
                    FROM PRODUTO PRO 
                    LEFT JOIN CATEGORIA CAT ON CAT.CATEGORIA_ID = PRO.CATEGORIA_ID 
                    LEFT JOIN PRODUTO_ESTOQUE EST ON EST.PRODUTO_ID = PRO.PRODUTO_ID 
                    $sqlWhere  
                    ORDER BY 
                        PRODUTO_ID DESC";
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
             ":DESC"=>$this->getDesc(),
             ":PRECO"=>$this->desmascararValor($this->getPreco()),
             ":DESCONTO"=>$this->desmascararValor($this->getDesconto()),
             ":CATEGORIA"=>$this->getCategoria(),        
        ];
        
        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

        if($this->getId() == 0){
            $response = json_encode(["status"=> 500, "title"=>"Erro inesperado", "message"=>"Ocorreu um erro ao cadastrar o produto. Tente novamente mais tarde."]);
        }else{
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

       $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":DESC"=>$this->getDesc(),
            ":PRECO"=>$this->desmascararValor($this->getPreco()),
            ":DESCONTO"=>$this->desmascararValor($this->getDesconto()),
            ":CATEGORIA"=>intval($this->getCategoria()),
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
            if($this->validarProdutoExistente()){
                $response = json_encode([
                    "status"=> 400, 
                    "title"=>"Dado inválido", 
                    "message"=>"Já existe um produto cadastrado com este nome. Não será possível ativá-lo.",
                    "items"=>[]
                ]);
            }
    
            if(!$this->validarCategoriaExistente()){
                $response = json_encode([
                    "status"=> 400, 
                    "title"=>"Dado inválido", 
                    "message"=>"Categoria do produto inválida ou inativa no sistema. Ajuste a mesma antes de ativar o produto.",
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
    public function validarProduto(){
        $response = "";

        if($this->getNome() == ""){
            $response = ["status"=> 400, "title"=>"Dado inválido",  "message"=>"O campo de nome não foi preenchido."];
        } elseif ($this->getCategoria() == 0) {
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"O campo de categoria não foi preenchido."];
        } elseif ($this->desmascararValor($this->getPreco()) == 0 ){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"O campo de preço não foi preenchido."];
        } elseif(!$this->validarCategoriaExistente()){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Categoria inválida ou inativa no sistema."];
        } elseif($this->validarProdutoExistente()){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Já existe um produto cadastrado com este nome. Tente um nome diferente."];
        } elseif($this->desmascararValor($this->getDesconto()) > $this->desmascararValor($this->getPreco())){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Não é permitido aplicar um desconto maior do que o preço do produto."];            
        } elseif($this->desmascararValor($this->getPreco()) < 0){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Não é permitido informar valores negativos no preço."];            
        } elseif($this->desmascararValor($this->getDesconto()) < 0){
            $response = ["status"=> 400, "title"=>"Dado inválido", "message"=>"Não é permitido informar valores negativos no desconto."];            
        } else{
            $response = ["status"=> 200, "title"=>"Dado inválido", "message"=>"Ok"];
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

    private function validarCategoriaExistente(){
        $sql = new Sql();

        $query = "SELECT CAT.CATEGORIA_ID FROM CATEGORIA CAT WHERE CAT.CATEGORIA_ID = :CATEGORIA AND COALESCE(CAT.CATEGORIA_ATIVO, 1) = 1";
        $params = [
            ":CATEGORIA"=>$this->getCategoria()
        ];

        $data = $sql->select($query, $params);

        $categoriaExistente = count($data) > 0 ? true : false; 

        return($categoriaExistente);
    }

    private function desmascararValor($valor):float{
        return(floatval(str_replace(',', '.', str_replace('.', '', $valor))));
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
