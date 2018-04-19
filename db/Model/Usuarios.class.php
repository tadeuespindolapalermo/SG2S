<?php

class Usuarios {

    private $idusuarios;
    private $nome;
    private $fone;
    private $email;
    private $usuario;
    private $senha;       

    public function getIdUsuarios() {
        return $this->idusuarios;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getFone() {
        return $this->fone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }   

    public function setIdUsuarios($idusuarios) {
        $this->idusuarios = $idusuarios;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setFone($fone) {
        $this->fone = $fone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }  

}
