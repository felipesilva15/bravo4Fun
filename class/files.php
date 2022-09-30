<?php

class Files {
    private $file, $dirFile, $filePath;

    public function __construct($dirFile = ""){
        if($dirFile){
            $this->dirFile = $dirFile;
        } else{
            $this->dirFile = "assets";
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

    public function getFile(){
        return($this->file);
    }

    public function setFilePath($filePath){
        $this->filePath = $filePath;
    }

    public function getFilePath():string{
        return($this->filePath);
    }

    public function uploadFile(){
        $this->createDir($this->getDirFile());

        $file = $this->getFile();
        $fullPath = $this->getDirFile() . DIRECTORY_SEPARATOR . $file["name"];

        if(is_file($fullPath)){
            return(json_encode(["status"=> 400, "message"=>"Já existe este arquivo no servidor", "items"=>[]]));
        }

        if(move_uploaded_file($file["tmp_name"], $fullPath)){
            $response = json_encode(["status"=> 200, "message"=>"Upload realizado com sucesso!", "items"=>[]]);
        }else{
            $response = json_encode(["status"=> 500, "message"=>"Falha ao realizar upload.", "items"=>[]]);
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

    private function createDir($dir){
        if(!is_dir($dir)){
            mkdir($dir);
        }
    }
}