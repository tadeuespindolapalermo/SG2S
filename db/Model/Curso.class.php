<?php

class Curso {

    // Atributos do Banco de Dados
    private $idCurso;
    private $nome;
    private $portaria;
    private $duracao;
    private $grau;
    private $dataPortaria;
    private $versaoMatriz;    

    // Getters dos Atributos do Banco
    public function getIdCurso() {
        return $this->idCurso;
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

    public function getVersaoMatriz() {
        return $this->versaoMatriz;
    }

    // Setters dos Atributos do Banco
    public function setIdCurso($idCurso) {
        $this->idCurso = $idCurso;
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

    public function setVersaoMatriz($versaoMatriz) {
        $this->versaoMatriz = $versaoMatriz;
    }

}
