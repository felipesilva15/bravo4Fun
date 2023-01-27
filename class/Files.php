<?php

class Files {
    private $file, $fileDir, $filePath, $imgurClientID, $uploadType;

    public function __construct($fileDir = ""){
        if($fileDir){
            $this->setFileDir($fileDir);
        } else{
            $this->setFileDir("assets");
        }

        $this->setImgurClientID("e27d6f9aee55c39");
        $this->setUploadType(1);
    }

    public function setFileDir($fileDir){
        $this->fileDir = $fileDir;
    }

    public function getFileDir():string{
        return($this->fileDir);
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

    public function setUploadType($uploadType){
        $this->uploadType = $uploadType;
    }

    public function getUploadType():int{
        return($this->uploadType);
    }

    public function uploadFile(){
        // Valida o arquivo 
        $resValid = $this->validFile();

        if($resValid["status"] >= 400){
            return(json_encode($resValid));
        }

        // Upload com base no tipo definido
        switch ($this->getUploadType()) {
            case 0: // Upload local no servidor do PHP
                $response = $this->uploadFileToPhpServer();
                break;
            
            case 1; // Upload online no repositório remoto do Imgur
                $response = $this->uploadFileToRepository();
                break;

            default: 
                $response = json_encode([
                    "status"=> 400, 
                    "message"=>"Opção de upload inválida.", 
                    "items"=>[]
                ]);
                break;
        }

        // Retorna a resposta
        return($response);
    }

    public function downloadFile(){
        // Cria o diretório
        $this->createDir();

        // Pega o conteúdo do link indicado e pega o nome do arquivo
        $content = file_get_contents($this->getFilePath());
        $sourceFilename = parse_url($this->getFilePath())["path"];

        do {
            // Define um novo nome para o arquivo 
            $filename = $this->makeFilename($sourceFilename);
            $this->setFilePath($this->getFileDir().DIRECTORY_SEPARATOR.$filename);
        } while (is_file($this->getFilePath()));

        // Cria o array de arquivo para validação
        $this->setFile([
            "name"=>basename($sourceFilename),
            "size"=>strlen($content)
        ]);

        // Valida o arquivo
        $resValid = $this->validFile();

        if($resValid["status"] >= 400){
            return(json_encode($resValid));
        }

        // Cria o arquivo no PHP e o preenche com os dados obtidos no link
        $file = fopen($this->getFilePath(), "w+");
        fwrite($file, $content);
        fclose($file);

        // Retorna a resposta de sucesso
        return(json_encode([
            "status"=> 200, 
            "message"=>"Download realizado com sucesso.", 
            "items"=>[]
        ]));
    }

    private function createDir(){
        // Cria o diretório do arquivo caso o mesmo não exista
        if(!is_dir($this->getFileDir())){
            mkdir($this->getFileDir());
        }
    }

    private function makeFilename($sourceFilename):string{
        // Cria um nome de arquivo aleatório, mantendo a extensão
        $newFilename = md5(uniqid());
        $extension = pathinfo($sourceFilename, PATHINFO_EXTENSION);

        $newFilename = "{$newFilename}.{$extension}";

        return($newFilename);
    }

    private function validFile():array{
        // Define as extensões permitidas e pega a extensão do arquivo
        $aprovedExtensions = ["png", "jpg", "jpeg", "gif", "jfif", "bmp"];
        $fileExtension = pathinfo($this->getFile()["name"], PATHINFO_EXTENSION);

        if(!in_array($fileExtension, $aprovedExtensions)){ // Valida se a extensão é permitida
            $response = ["status"=> 400, "title"=>"Arquivo inválido", "message"=>"Extensão do arquivo não permitida!", "items"=>[]];
        } elseif($this->getFile()["size"] > 2097152) { // Valida se está dentro do tamanho máximo permitido
            $response = ["status"=> 400, "title"=>"Arquivo inválido", "message"=>"Só é permitido arquivos com tamanho máximo de 2MB!", "items"=>[]];            
        } else{
            $response = ["status"=> 200, "title"=>"OK", "message"=>"Arquivo válido.", "items"=>[]];            
        }

        return($response);
    }

    private function uploadFileToRepository():string{  
        // Transforma o arquivo em stream
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
    
        // Valida correu tudo bem com a requisição
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
        
        // Valida se obteve todos os dados do upload
        if(!$response["data"]["link"] || $response["data"]["link"] == ""){
            return(json_encode([
                "status"=> 500, 
                "title"=>"Falha no upload", 
                "message"=>"Ocorreu um erro ao realizar o upload do arquivo", 
                "items"=>[]
            ]));
        }

        // Armazena o link da imagem 
        $this->setFilePath($response["data"]["link"]);

        // Retorna a resposta de sucesso
        return(json_encode([
            "status"=> 200, 
            "message"=>"Upload realizado com sucesso.", 
            "items"=>[
                "file"=>$this->getFile(),
                "filePath"=>$this->getFilePath()
            ]
        ]));
    }

    private function uploadFileToPhpServer():string{ 
        // Cria um diretório
        $this->createDir();

        do {
            // Define um novo nome para o arquivo 
            $filename = $this->makeFilename($this->getFile()["name"]);
            $this->setFilePath($this->getFileDir().DIRECTORY_SEPARATOR.$filename);
        } while (is_file($this->getFilePath()));

        // Move o arquivo da temp para a pasta do servidor PHP
        $uploaded = move_uploaded_file($this->getFile()["tmp_name"], $this->getFilePath());

        // Valida se ocorreu um erro
        if(!$uploaded){
            return(json_encode([
                "status"=> 500, 
                "message"=>"Falha ao realizar upload.", 
                "items"=>[]
            ]));
        }

        // Retorna a resposta de sucesso
        return(json_encode([
            "status"=> 200, 
            "message"=>"Upload realizado com sucesso.", 
            "items"=>[
                "fileDir"=>$this->getFileDir(),
                "file"=>$this->getFile(),
                "filePath"=>$this->getFilePath(),
            ]
        ]));
    }
}
