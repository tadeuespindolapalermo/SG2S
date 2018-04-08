<?php

class Curso {
    
    private $idcurso;
    private $nome;
    private $portaria;
    private $duracao;
    private $grau;
    private $dataPortaria;
    
    public function getIdcurso() {
        return $this->idcurso;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPortaria() {
        return $this->portaria;
    }

    public function getDuracao() {
        return $this->duracao;
    }

    public function getGrau() {
        return $this->grau;
    }

    public function getDataPortaria() {
        return $this->dataPortaria;
    }

    public function setIdcurso($idcurso) {
        $this->idcurso = $idcurso;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setPortaria($portaria) {
        $this->portaria = $portaria;
    }

    public function setDuracao($duracao) {
        $this->duracao = $duracao;
    }

    public function setGrau($grau) {
        $this->grau = $grau;
    }

    public function setDataPortaria($dataPortaria) {
        $this->dataPortaria = $dataPortaria;
    }   
    
}
