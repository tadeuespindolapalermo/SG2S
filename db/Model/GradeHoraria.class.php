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
    private $dsSeg;
    private $dsTer;
    private $dsQua;
    private $dsQui;
    private $dsSex;
    private $dsSab;
    private $dsEad; 

    // Atributos auxiliares
    private $cursoNome;
    private $disciplinaNome;
    private $disciplinaId;    

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
    
    //------ DIAS DA SEMANA ----------
    public function getDsSeg() {
        return $this->dsSeg;
    }
    
    public function getDsTer() {
        return $this->dsTer;
    }
    
    public function getDsQua() {
        return $this->dsQua;
    }
    
    public function getDsQui() {
        return $this->dsQui;
    }
    
    public function getDsSex() {
        return $this->dsSex;
    }
    
    public function getDsSab() {
        return $this->dsSab;
    }
    
    public function getDsEad() {
        return $this->dsEad;
    }

    // Getters dos Atributos Auxiliares
    public function getCursoNome() {
        return $this->cursoNome;
    }

    public function getDisciplinaNome() {
        return $this->disciplinaNome;
    }

    public function getDisciplinaId() {
        return $this->disciplinaId;
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
    
    //--------- DIAS DA SEMANA -------------
    public function setDsSeg($dsSeg) {
        $this->dsSeg = $dsSeg;
    }
    
    public function setDsTer($dsTer) {
        $this->dsTer = $dsTer;
    }
    
    public function setDsQua($dsQua) {
        $this->dsQua = $dsQua;
    }
    
    public function setDsQui($dsQui) {
        $this->dsQui = $dsQui;
    }
    
    public function setDsSex($dsSex) {
        $this->dsSex = $dsSex;
    }
    
    public function setDsSab($dsSab) {
        $this->dsSab = $dsSab;
    }
    
    public function setDsEad($dsEad) {
        $this->dsEad = $dsEad;
    }

    // Setters dos Atributos Auxiliares
    public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }

    public function setDisciplinaNome($disciplinaNome) {
        $this->disciplinaNome = $disciplinaNome;
    }

    public function setDisciplinaId($disciplinaId) {
        $this->disciplinaId = $disciplinaId;
    }

}
