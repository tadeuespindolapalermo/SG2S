<?php

class Grade {
    
    private $idgradeSemestral;
    private $anoLetivo;
    private $semestre;
    private $periodo;
    private $horario;
    private $sala;
    private $quantidadeAlunos;
    private $turmas;
    private $cursoIdcurso;
    
    public function getIdgradeSemestral() {
        return $this->idgradeSemestral;
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

    public function getCursoIdcurso() {
        return $this->cursoIdcurso;
    }

    public function setIdgradeSemestral($idgradeSemestral) {
        $this->idgradeSemestral = $idgradeSemestral;
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

    public function setCursoIdcurso($cursoIdcurso) {
        $this->cursoIdcurso = $cursoIdcurso;
    }   

}
