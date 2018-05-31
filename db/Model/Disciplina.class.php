<?php

class Disciplina {

    // Atributos do Banco de Dados
    private $idDisciplina;
    private $cursoIdCurso;
    private $nomeDisciplina;
    private $cargaHoraria;
    private $credito;

    // Atributos Auxiliares
    //private $cursoNome;
    private $idProfessorDisciplina;

    // Getters dos Atributos do Banco
    public function getIdDisciplina() {
        return $this->idDisciplina;
    }

    public function getCursoIdCurso() {
        return $this->cursoIdCurso;
    }

    public function getNomeDisciplina() {
        return $this->nomeDisciplina;
    }

    public function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    public function getCredito() {
        return $this->credito;
    }

    // Getters dos Atributos Auxiliares
    /*public function getCursoNome() {
        return $this->cursoNome;
    }*/

    public function getIdProfessorDisciplina() {
        return $this->idProfessorDisciplina;
    }

    // Setters dos Atributos do Banco
    public function setIdDisciplina($idDisciplina) {
        $this->idDisciplina = $idDisciplina;
    }

    public function setCursoIdCurso($cursoIdCurso) {
        $this->cursoIdCurso = $cursoIdCurso;
    }

    public function setNomeDisciplina($nomeDisciplina) {
        $this->nomeDisciplina = $nomeDisciplina;
    }

    public function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }

    public function setCredito($credito) {
        $this->credito = $credito;
    }

    // Setters dos Atributos Auxiliares
    /*public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }*/

    public function setIdProfessorDisciplina($idProfessorDisciplina) {
        $this->idProfessorDisciplina = $idProfessorDisciplina;
    }

}
