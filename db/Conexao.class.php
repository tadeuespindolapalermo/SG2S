<?php

class Conexao {

    private $host = 'localhost';
    private $usuario = 'root';
    private $senha = 'mysql1985';
    private $database = 'SG2S';

    public function conectar() {

        // Cria a conexão
        $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

        // Charset de comunicação entre a aplicação e o banco de dados
        mysqli_set_charset($con, 'utf-8');

        // Verifica se houve erro de conexão
        if (mysqli_connect_errno()) {
            echo 'Erro ao tentar se conectar com o Banco de Dados: ' . mysqli_connect_error();
        }
        return $con;
    }
}
