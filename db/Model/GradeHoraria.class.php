<?php

class GradeHoraria {

    // Atributos do Banco de Dados
    private $idGradeHoraria;
    private $sala;
    private $quantidadeAlunos;
    private $turmas;
    private $periodoCurso;
    private $diaSemana;
    private $ead;
    private $idGradeSemestral;
    private $idCursoGradeSemestral;

    // Atributos auxiliares
    private $cursoNome;

    // Getters dos Atributos do Banco
    public function getIdGradeHoraria()  {
        return $this->idGradeHoraria;
    }

    public function getSala()  {
        return $this->sala;
    }

    public function getQuantidadeAlunos() {
        return $this->quantidadeAlunos;
    }

    public function getTurmas() {
        return $this->turmas;
    }

    public function getPeriodoCurso() {
        return $this->periodoCurso;
    }

    public function getDiaSemana() {
        return $this->diaSemana;
    }

    public function getEad() {
        return $this->ead;
    }

    public function getIdGradeSemestral() {
        return $this->idGradeSemestral;
    }

    public function getIdCursoGradeSemestral() {
        return $this->idCursoGradeSemestral;
    }

    // Getters dos Atributos Auxiliares
    public function getCursoNome() {
        return $this->cursoNome;
    }

    // Setters dos Atributos do Banco
    public function setIdGradeHoraria($idGradeHoraria) {
        $this->idGradeHoraria = $idGradeHoraria;
    }

    public function setSala($sala) {
        $this->sala = $sala;
    }

    public function setQuantidadeAlunos($quantidadeAlunos) {
        $this->quantidadeAlunos = $quantidadeAlunos;
    }

    public function setTurmas($turmas) {
        $this->turmas = $turmas;
    }

    public function setPeriodoCurso($periodoCurso) {
        $this->periodoCurso = $periodoCurso;
    }

    public function setDiaSemana($diaSemana) {
        $this->diaSemana = $diaSemana;
    }

    public function setEad($ead) {
        $this->ead = $ead;
    }

    public function setIdGradeSemestral($idGradeSemestral) {
        $this->idGradeSemestral = $idGradeSemestral;
    }

    public function setIdCursoGradeSemestral($idCursoGradeSemestral) {
        $this->idCursoGradeSemestral = $idCursoGradeSemestral;
    }

    // Setters dos Atributos Auxiliares
    public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }
}
