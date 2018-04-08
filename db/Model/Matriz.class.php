<?php

class Matriz {
    
    private $idmatrizCurricular;
    private $cursoIdcurso;
    private $nome;
    private $cargaHoraria;
    private $credito;
    
    public function getIdmatrizCurricular() {
        return $this->idmatrizCurricular;
    }

    public function getCursoIdcurso() {
        return $this->cursoIdcurso;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    public function getCredito() {
        return $this->credito;
    }

    public function setIdmatrizCurricular($idmatrizCurricular) {
        $this->idmatrizCurricular = $idmatrizCurricular;
    }

    public function setCursoIdcurso($cursoIdcurso) {
        $this->cursoIdcurso = $cursoIdcurso;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }

    public function setCredito($credito) {
        $this->credito = $credito;
    }   
    
}
