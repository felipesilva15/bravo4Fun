<?php

class ProdutoImagem{
    private $id = 0, $produto = 0, $url = "", $ordem = 0, $imagens = [];

    public function getId():int{
        return($this->id);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getProduto():int{
        return($this->produto);
    }

    public function setProduto($produto){
        $this->produto = $produto;
    }

    public function getUrl():string{
        return($this->url);
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function getOrdem():int{
        return($this->ordem);
    }

    public function setOrdem($ordem){
        $this->ordem = $ordem;
    }

    public function getImagens():array{
        return($this->imagens);
    }

    public function setImagens($imagens){
        $this->imagens = $imagens;
    }

    public function getProdutoImagens($exibirInativo = 0){
        $sql = new Sql();

        $sqlWhere = "";
        $params = [];

        if($this->getProduto() != 0){
            $sqlWhere .= " AND PRODUTO_ID = :PRODUTO_ID";
            $params[":PRODUTO_ID"] = $this->getProduto();
        }
        if($exibirInativo == 0){
            $sqlWhere .= " AND COALESCE(IMAGEM_ORDEM, -1) >= 0";
        }
        
        //Esse bloco é para limitar a quantidades de dados a ser digitado pelo usuário?
        if($sqlWhere !== ""){
            $sqlWhere = " WHERE " . substr($sqlWhere, 5);
        }

        $query = "SELECT * FROM PRODUTO_IMAGEM $sqlWhere ORDER BY IMAGEM_ORDEM";

        $data = $sql->select($query, $params);

        return($data);
    }

    public function atualizarImagens(){
        foreach ($this->getImagens() as $imagem) {
            $this->setId($imagem["IMAGEM_ID"]);
            $this->setUrl($imagem["IMAGEM_URL"]);
            $this->setOrdem($imagem["IMAGEM_ORDEM"]);

            if($this->getId() != 0){
                $response = $this->update();
            } else{
                $response = $this->insert();
            }
        }

        $response = json_encode(["status"=> 200, "message"=>"Ok", "items"=>[]]);

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $query = "INSERT INTO PRODUTO_IMAGEM (PRODUTO_ID, IMAGEM_URL, IMAGEM_ORDEM) VALUES (:PRODUTO, :URL, :ORDEM)";
        $params = [
            ":PRODUTO_ID"=>$this->getProduto(),
            ":URL"=>$this->getUrl(),
            ":ORDEM"=>$this->getOrdem()
        ];

        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

        if($this->getId() == 0){
            $response = json_encode(["status"=> 500, "message"=>"Erro ao cadastrar imagem!"]);
        }else{
            //$this->loadById();

            $response = json_encode(["status"=> 200, "message"=>"Ok", "items"=>[]]);
        }

        return($response); 
    }

    public function update(){
        $sql = new Sql();

        $query = "UPDATE PRODUTO_IMAGEM SET PRODUTO_ID = :PRODUTO, IMAGEM_URL = :URL, IMAGEM_ORDEM = :ORDEM WHERE IMAGEM_ID = :ID";
        $params = [
            ":ID"=>$this->getId(),
            ":PRODUTO"=>$this->getProduto(),
            ":URL"=>$this->getUrl(),
            ":ORDEM"=>$this->getOrdem()
        ];

        $sql->executeQuery($query, $params);
        //$this->loadById();

        $response = json_encode(["status"=> 200, "message"=>"OK", "items"=>[]]);
        
        return($response);
    }

    public function __toString():string{
        return(json_encode([
            "PRODUTO_ID"=>$this->getProduto(),
            "IMAGENS"=>$this->getImagens()
        ]));
    }
}