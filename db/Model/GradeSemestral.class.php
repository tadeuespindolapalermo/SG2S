<?php

class GradeSemestral {

    // Atributos do Banco de Dados
    private $idGradeSemestral;
    private $anoLetivo;
    private $semestreLetivo;
    private $turno;
    private $horario;
    private $cursoIdCurso;

    // Atributos auxiliares
    private $idGlobals;
    private $cursoNome;
    private $cursoGrau;

    // Getters dos Atributos do Banco
    public function getIdGradeSemestral() {
        return $this->idGradeSemestral;
    }

    public function getAnoLetivo() {
        return $this->anoLetivo;
    }

    public function getSemestreLetivo() {
        return $this->semestreLetivo;
    }

    public function getTurno() {
        return $this->turno;
    }

    public function getHorario()  {
        return $this->horario;
    }

    public function getCursoIdCurso() {
        return $this->cursoIdCurso;
    }

    // Getters dos Atributos Auxiliares
    public function getIdGlobals() {
        return $this->idGlobals;
    }

    public function getCursoNome() {
        return $this->cursoNome;
    }

    public function getCursoGrau() {
        return $this->cursoGrau;
    }

    // Setters dos Atributos do Banco
    public function setIdGradeSemestral($idGradeSemestral) {
        $this->idGradeSemestral = $idGradeSemestral;
    }

    public function setAnoLetivo($anoLetivo) {
        $this->anoLetivo = $anoLetivo;
    }

    public function setSemestreLetivo($semestreLetivo) {
        $this->semestreLetivo = $semestreLetivo;
    }

    public function setTurno($turno) {
        $this->turno = $turno;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public function setCursoIdCurso($cursoIdCurso) {
        $this->cursoIdCurso = $cursoIdCurso;
    }

    // Setters dos Atributos Auxiliares
    public function setIdGlobals($idGlobals) {
        $this->idGlobals = $idGlobals;
    }

    public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }

    public function setCursoGrau($cursoGrau) {
        $this->cursoGrau = $cursoGrau;
    }

}
