<?php

class Conexao {

    private $host = 'xmysql2.codigofonteonline.com.br';
    private $usuario = 'codigofonteonli1';
    private $senha = 'sg2s1985@';
    private $database = 'codigofonteonline1';

    // Conexão sem PDO
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

    // Conexão com PDO
    public function getConnection() {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8';
        $user = $this->usuario;
        $pass = $this->senha;

        try {
            $pdo = new PDO($dsn, $user, $pass);
            return $pdo;
        } catch (PDOException $ex) {
            echo 'Erro ao tentar se conectar com o Banco de Dados: '.$ex->getMessage();
        }
    }

    // Executa consultas no Banco de Dados
    public function executarConsulta($link, $strSql) {
        $rs = mysqli_query($link, $strSql);
        return $rs;
    }

    // Atualização de Usuários
    public function atualizarUsuario($link, $strSql) {
        mysqli_query($link, $strSql);
        $id = mysqli_insert_id($link);
        return $id;
    }

}
