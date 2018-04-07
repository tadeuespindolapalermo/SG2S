<?php

class Perfil {
    
    private $idperfil;
    private $descricao;
    
    public function getIdPerfil() {
        return $this->idperfil;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdPerfil($idperfil) {
        $this->idperfil = $idperfil;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }    
    
}