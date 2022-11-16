<?php

class ProdutoEstoque{
    private $produto = "", $quantidade = 0;

    public function getProduto():int{
        return($this->produto);
    }

    public function setProduto($produto){
        $this->produto = $produto;
    }

    public function getQuantidade():int{
        return($this->quantidade);
    }

    public function setQuantidade($quantidade){
        $this->quantidade = intval(str_replace(',','.',(str_replace('.','',$quantidade))));;
    }

    public function setData($data = []){
        $this->setProduto(isset($data["PRODUTO_ID"]) ? $data["PRODUTO_ID"] : 0);
        $this->setQuantidade(isset($data["PRODUTO_QTD"]) ? $data["PRODUTO_QTD"] : 0);
    }

    public function unsetData(){
        $this->setProduto(0);
        $this->setQuantidade(0);
    }

    public function getEstoques(){
        $sql = new Sql();

        $sqlWhere = "";
        $params = [];

        if($this->getProduto() != 0){
            $sqlWhere .= " AND PRODUTO_ID = :PRODUTO";
            $params[":PRODUTO"] = $this->getProduto();
        }
        
        //Esse bloco é para limitar a quantidades de dados a ser digitado pelo usuário?
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM PRODUTO_ESTOQUE $sqlWhere ORDER BY PRODUTO_ID DESC";

        $data = $sql->select($query, $params);

        return($data);
    }

    public function atualizarEstoque(){
        $response = "";

        if($this->getProduto() == 0){
            $response = $this->insert();
        } else{
            $response = $this->update();
        }

        return($response);
    }

    public function loadByProduto(){
        $sql = new Sql();

        $query = "SELECT * FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :PRODUTO";
        $params = [
            ":PRODUTO"=>$this->getProduto()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["status"=> 500, "message"=>"Produto inválido!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["status"=> 200, "message"=>"Ok", "items"=>[]]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $resValidar = $this->validarEstoque();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:PRODUTO, :ESTOQUE)";
        $params = [
            ":PRODUTO"=>$this->getProduto(),
            ":ESTOQUE"=>$this->getQuantidade(),
        ];

        $exito = $sql->executeQuery($query, $params);

        if(!$exito){
            $response = json_encode(["status"=> 500, "message"=>"Erro ao cadastrar estoque do produto!"]);
        }else{
            $this->loadByProduto();

            $response = json_encode(["status"=> 200, "message"=>"Ok", "items"=>[]]);
        }

        return($response); 
    }

    public function update(){
        $sql = new Sql();

        $resValidar = $this->validarEstoque();

        if($resValidar["status"] != 200){
            return(json_encode($resValidar));
        }

        $query = "UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :ESTOQUE WHERE PRODUTO_ID = :PRODUTO";
        $params = [
            ":PRODUTO"=>$this->getProduto(),
            ":ESTOQUE"=>$this->getQuantidade()
        ];

        $sql->executeQuery($query, $params);
        $this->loadByProduto();

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }

    public function validarEstoque(){
        $response = "";

        if(!$this->validarProdutoExistente()){
            $response = ["status"=>400, "title"=>"Dado inválido", "message"=>"Produto informado não existe na base de dados ou não se encontra ativo."];
        } else{
            $response = ["status"=>200, "title"=>"Dado inválido", "message"=>"Ok"];
        }

        return($response);
    }

    private function validarProdutoExistente(){
        $sql = new Sql();

        $query = "SELECT * FROM PRODUTO WHERE PRODUTO_ID = :PRODUTO AND COALESCE(PRODUTO_ATIVO, 1) = 1";
        $params = [
            ":PRODUTO"=>$this->getProduto()
        ];

        $data = $sql->select($query, $params);

        $produtoExiste = count($data) > 0 ? true : false; 

        return($produtoExiste);
    }

    public function __toString():string{
        return(json_encode([
            "PRODUTO_ID"=>$this->getProduto(),
            "PRODUTO_QTD"=>$this->getQuantidade()
        ]));
    }
}