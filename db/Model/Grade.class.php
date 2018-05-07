<?php

class Grade {

    private $idGradeSemestral;
    private $anoLetivo;
    private $semestre;
    private $periodo;
    private $horario;
    private $sala;
    private $quantidadeAlunos;
    private $turmas;
    private $cursoIdCurso;
    private $cursoNome;

    // Atributos auxiliares provisórios
    private $segunda;
    private $terca;
    private $quarta;
    private $quinta;
    private $sexta;
    private $sabado;
    private $ead;

    public function getIdGradeSemestral() {
        return $this->idGradeSemestral;
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

    // auxiliares GET
    public function getSegunda() {
        return $this->segunda;
    }

    public function getTerca() {
        return $this->terca;
    }

    public function getQuarta() {
        return $this->quarta;
    }

    public function getQuinta() {
        return $this->quinta;
    }

    public function getSexta() {
        return $this->sexta;
    }

    public function getSabado() {
        return $this->sabado;
    }

    public function getEad() {
        return $this->ead;
    }
    // ------------------------

    // auxiliares SET
    public function setSegunda($segunda) {
        $this->segunda = $segunda;
    }

    public function setTerca($terca) {
        $this->terca = $terca;
    }

    public function setQuarta($quarta) {
        $this->quarta = $quarta;
    }

    public function setQuinta($quinta) {
        $this->quinta = $quinta;
    }

    public function setSexta($sexta) {
        $this->sexta = $sexta;
    }

    public function setSabado($sabado) {
        $this->sabado = $sabado;
    }

    public function setEad($ead) {
        $this->ead = $ead;
    }

    // -------------------

    public function setIdGradeSemestral($idGradeSemestral) {
        $this->idGradeSemestral = $idGradeSemestral;
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

}
