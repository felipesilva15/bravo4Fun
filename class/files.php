<?php

class Files {
    private $file, $dirFile, $filePath, $imgurClientID;

    public function __construct($dirFile = ""){
        if($dirFile){
            $this->setDirFile($dirFile);
        } else{
            $this->setDirFile("assets");
        }

        $this->setImgurClientID("e27d6f9aee55c39");
    }

    public function setDirFile($dirFile){
        $this->dirFile = $dirFile;
    }

    public function getDirFile():string{
        return($this->dirFile);
    }

    public function setFile($file){
        $this->file = $file;
    }

    public function getFile():array{
        return($this->file);
    }

    public function setFilePath($filePath){
        $this->filePath = $filePath;
    }

    public function getFilePath():string{
        return($this->filePath);
    }

    public function setImgurClientID($imgurClientID){
        $this->imgurClientID = $imgurClientID;
    }

    public function getImgurClientID():string{
        return($this->imgurClientID);
    }

    public function uploadFile(){
        $resValid = $this->validFile();

        if($resValid["status"] >= 400){
            return(json_encode($resValid));
        }

        $this->createDir();

        do {
            $filename = $this->makeFilename();
            $this->setFilePath($this->getDirFile().DIRECTORY_SEPARATOR.$filename);
        } while (is_file($this->getFilePath()));

        $response = $this->uploadFileToRepository();

        return($response);
    }

    public function downloadFile(){
        $content = file_get_contents($this->getFilePath());

        $parse = parse_url($this->getFilePath());
        $basename = $this->getDirFile().DIRECTORY_SEPARATOR.basename($parse["path"]);

        $file = fopen($basename, "w+");

        fwrite($file, $content);

        fclose($file);

        echo "<a href=\"{$this->getFilePath()}\" download>Download</a>";
    }

    private function createDir(){
        if(!is_dir($this->getDirFile())){
            mkdir($this->getDirFile());
        }
    }

    private function makeFilename():string{
        $newFilename = md5(uniqid());
        $extension = pathinfo($this->getFile()["name"], PATHINFO_EXTENSION);

        $newFilename = "{$newFilename}.{$extension}";

        return($newFilename);
    }

    private function validFile():array{
        $aprovedExtensions = ["png", "jpg", "jpeg", "jfif", "bmp"];
        $fileExtension = pathinfo($this->getFile()["name"], PATHINFO_EXTENSION);

        if(!in_array($fileExtension, $aprovedExtensions)){
            $response = ["status"=> 400, "title"=>"Arquivo inválido", "message"=>"Extensão do arquivo não permitida!", "items"=>[]];
        } elseif($this->getFile()["size"] > 2097152) {
            $response = ["status"=> 400, "title"=>"Arquivo inválido", "message"=>"Só é permitido arquivos com tamanho máximo de 2MB!", "items"=>[]];            
        } else{
            $response = ["status"=> 200, "title"=>"OK", "message"=>"Arquivo válido.", "items"=>[]];            
        }

        return($response);
    }

    private function uploadFileToRepository():string{  
        $fileName = basename($_FILES["imagem"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 

        $handle = fopen($this->getFile()["tmp_name"], "rb");
        $imageSource = stream_get_contents($handle, filesize($this->getFile()["tmp_name"]));
    
        // Inicia o metodo para upload via POST do HTTP
        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json'); // Configura a url de destino
        curl_setopt($ch, CURLOPT_POST, TRUE); // Estabelece que sera via POST
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Client-ID {$this->getImgurClientID()}")); // Adiciona a chave do serviço ao cabeçalho da requisição
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => $imageSource)); // Adiciona os campos 
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Estabelece detalhes do processo
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Informa que aguardara o retorno
    
        // Executa a requisição
        $response = curl_exec($ch); 
        
        if(curl_errno($ch)) {
            return(json_encode([
                "status"=> 500, 
                "title"=>"Falha no upload", 
                "message"=>"Ocorreu um erro ao realizar o upload do arquivo", 
                "items"=>[]
            ]));
        }

        // Fecha a requisição
        curl_close($ch); 

        $response = json_decode($response, true); 
        
        if(!$response["data"]["link"] || $response["data"]["link"] == ""){
            return(json_encode([
                "status"=> 500, 
                "title"=>"Falha no upload", 
                "message"=>"Ocorreu um erro ao realizar o upload do arquivo", 
                "items"=>[]
            ]));
        }

        $this->setFilePath($response["data"]["link"]);

        return(json_encode([
            "status"=> 200, 
            "message"=>"Upload realizado com sucesso.", 
            "items"=>[
                "dirFile"=>$this->getDirFile(),
                "file"=>$this->getFile(),
                "filePath"=>$this->getFilePath(),
            ]
        ]));
    }
}