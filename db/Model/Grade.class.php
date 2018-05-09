<?php

class Grade {

    private $idGradeSemestral;
    private $idGlobals;
    private $anoLetivo;
    private $semestre;
    private $periodo;
    private $horario;
    private $sala;
    private $quantidadeAlunos;
    private $turmas;
    private $cursoIdCurso;
    private $cursoNome;
    private $cursoGrau;

    public function getIdGradeSemestral() {
        return $this->idGradeSemestral;
    }

    public function getIdGlobals() {
        return $this->idGlobals;
    }

    public function getAnoLetivo() {
        return $this->anoLetivo;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getHorario()  {
        return $this->horario;
    }

    public function getSala() {
        return $this->sala;
    }

    public function getQuantidadeAlunos()  {
        return $this->quantidadeAlunos;
    }

    public function getTurmas() {
        return $this->turmas;
    }

    public function getCursoIdCurso() {
        return $this->cursoIdCurso;
    }

    public function getCursoNome() {
        return $this->cursoNome;
    }

    public function getCursoGrau() {
        return $this->cursoGrau;
    }

    public function setIdGradeSemestral($idGradeSemestral) {
        $this->idGradeSemestral = $idGradeSemestral;
    }

    public function setIdGlobals($idGlobals) {
        $this->idGlobals = $idGlobals;
    }

    public function setAnoLetivo($anoLetivo) {
        $this->anoLetivo = $anoLetivo;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
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

    public function setCursoIdCurso($cursoIdCurso) {
        $this->cursoIdCurso = $cursoIdCurso;
    }

    public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }

    public function setCursoGrau($cursoGrau) {
        $this->cursoGrau = $cursoGrau;
    }


}
