<?php

class Sql extends PDO{
    private $conn;

    // Método construtor para criar atributo de conexão da classe
    public function __construct(){
        $config = require __DIR__ . '/../config.env.php';

        $this->conn = new PDO(
            "mysql:dbname={$config['db']};host={$config['server']}",
            $config['user'],
            $config['password']
        );
    }

    // Define um parâmetro da query com o bindValue
    public function setParameter($stmt, $key, $value){
        $stmt->bindParam($key, $value);
    }

    // Define todos os parâmetros da query com o bindValue em cada item do array de parâmetros da query
    public function setParameters($stmt, $parameters = []){
        foreach ($parameters as $key => $value) {
            $this->setParameter($stmt, $key, $value);
        }
    }

    // Prepara a query e a executa no BD
    // Utilize este método para comandos que NÃO retornam algo do BD
    public function executeQuery($query, $parameters = []){
        $stmt = $this->conn->prepare($query);

        $this->setParameters($stmt, $parameters);

        $stmt->execute();

        return($stmt);
    }

    // Realiza uma select no BD
    // Utilize este método para comandos que retornam algo do BD
    public function select($query, $parameters = []):array{
        $stmt = $this->executeQuery($query, $parameters);

        return ($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function returnLastId(){
        return($this->conn->lastInsertId());
    }
}