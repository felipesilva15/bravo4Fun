<?php

class Files {
    private $file, $dirFile, $filePath;

    public function __construct($dirFile = ""){
        if($dirFile){
            $this->dirFile = $dirFile;
        } else{
            $this->dirFile = DIRECTORY_SEPARATOR."bravo4Fun".DIRECTORY_SEPARATOR."assets";
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

    public function uploadFile(){
        $this->createDir($this->getDirFile());

        $file = $this->getFile();
        $fullPath = $this->getDirFile().DIRECTORY_SEPARATOR.$this->$file["name"];

        if(move_uploaded_file($file["tmp_name"](), $fullPath)){
            echo "Upload realizado com sucesso";
        }else{
            echo "Erro ao realizar o upload";
        }
    }

    public function downloadFile(){
        // Pega o conteúdo do arquivo
        $content = file_get_contents($this->filePath);

        // Pega as informações do arquivo
        $parse = parse_url($this->filePath);

        // Pega o nome do arquivo
        $basename = basename($parse["path"]);

        // Cria um arquivo com o nome original
        $file = fopen($basename, "w+");

        // Escreve o conteúdo baixado no arquivo criado
        fwrite($file, $content);

        fclose($file);

        // Exibe o arquivo baixado na tela
        echo "<img src=\"$basename\" >";
    }

    private function createDir($dir){
        if(!is_dir($dir)){
            mkdir($dir);
        }
    }
}