<?php

class Files {
    private $file, $dirFile, $filePath;

    public function __construct($dirFile = ""){
        if($dirFile){
            $this->setDirFile($dirFile);
        } else{
            $this->setDirFile("assets");
        }
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

        $uploaded = move_uploaded_file($this->getFile()["tmp_name"], $this->getFilePath());

        if($uploaded){
            $response = json_encode([
                "status"=> 200, 
                "message"=>"Upload realizado com sucesso.", 
                "items"=>[
                    "dirFile"=>$this->getDirFile(),
                    "file"=>$this->getFile(),
                    "filePath"=>$this->getFilePath(),
                ]
            ]);
        }else {
            $response = json_encode([
                "status"=> 500, 
                "message"=>"Falha ao realizar upload.", 
                "items"=>[]
            ]);
        }

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
}