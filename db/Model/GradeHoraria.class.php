<?php

class GradeHoraria {

    // Atributos do Banco de Dados
    private $idGradeHoraria;
    //private $sala;
    private $quantidadeAlunos;
    private $turmas;
    private $periodoCurso;
    //private $diaSemana;
    //private $ead;
    private $idGradeSemestral;
    private $idCursoGradeSemestral;
    private $dsSeg;
    private $dsTer;
    private $dsQua;
    private $dsQui;
    private $dsSex;
    private $dsSab;
    private $dsEad1;
    private $dsEad2;
    private $dsSegSala;
    private $dsTerSala;
    private $dsQuaSala;
    private $dsQuiSala;
    private $dsSexSala;
    private $dsSabSala;
    //private $dsEad1Sala;
    //private $dsEad2Sala;

    // Atributos auxiliares
    private $cursoNome;
    private $disciplinaNome;
    private $disciplinaId;
    private $cursoGrau;
    private $gradeSemestralAno;
    private $gradeSemestralSemestre;
    private $gradeSemestralCurso;
    private $gradeSemestralId;
    private $gradeSemestralHorario;
    private $verificaArray;
    private $dsSegProf;
    private $dsTerProf;
    private $dsQuaProf;
    private $dsQuiProf;
    private $dsSexProf;
    private $dsSabProf;
    private $dsEad1Prof;
    private $dsEad2Prof;

    // Getters dos Atributos do Banco
    public function getIdGradeHoraria()  {
        return $this->idGradeHoraria;
    }

    /*public function getSala()  {
        return $this->sala;
    }*/

    public function getQuantidadeAlunos() {
        return $this->quantidadeAlunos;
    }

    public function getTurmas() {
        return $this->turmas;
    }

    public function getPeriodoCurso() {
        return $this->periodoCurso;
    }

    /*public function getDiaSemana() {
        return $this->diaSemana;
    }

    public function getEad() {
        return $this->ead;
    }*/

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

    public function getDsEad1() {
        return $this->dsEad1;
    }

    public function getDsEad2() {
        return $this->dsEad2;
    }

    //------ SALAS ----------
    public function getDsSegSala() {
        return $this->dsSegSala;
    }

    public function getDsTerSala() {
        return $this->dsTerSala;
    }

    public function getDsQuaSala() {
        return $this->dsQuaSala;
    }

    public function getDsQuiSala() {
        return $this->dsQuiSala;
    }

    public function getDsSexSala() {
        return $this->dsSexSala;
    }

    public function getDsSabSala() {
        return $this->dsSabSala;
    }

    /*public function getDsEad1Sala() {
        return $this->dsEad1Sala;
    }

    public function getDsEad2Sala() {
        return $this->dsEad2Sala;
    }*/

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

    public function getCursoGrau() {
        return $this->cursoGrau;
    }

    public function getGradeSemestralAno() {
        return $this->gradeSemestralAno;
    }

    public function getGradeSemestralSemestre() {
        return $this->gradeSemestralSemestre;
    }

    public function getGradeSemestralCurso() {
        return $this->gradeSemestralCurso;
    }

    public function getGradeSemestralId() {
        return $this->gradeSemestralId;
    }

    public function getGradeSemestralHorario() {
        return $this->gradeSemestralHorario;
    }

    public function getVerificaArray() {
        return $this->verificaArray;
    }

    //------ PROFESSORES ----------
    public function getDsSegProf() {
        return $this->dsSegProf;
    }

    public function getDsTerProf() {
        return $this->dsTerProf;
    }

    public function getDsQuaProf() {
        return $this->dsQuaProf;
    }

    public function getDsQuiProf() {
        return $this->dsQuiProf;
    }

    public function getDsSexProf() {
        return $this->dsSexProf;
    }

    public function getDsSabProf() {
        return $this->dsSabProf;
    }

    public function getDsEad1Prof() {
        return $this->dsEad1Prof;
    }

    public function getDsEad2Prof() {
        return $this->dsEad2Prof;
    }

    // Setters dos Atributos do Banco
    public function setIdGradeHoraria($idGradeHoraria) {
        $this->idGradeHoraria = $idGradeHoraria;
    }

    /*public function setSala($sala) {
        $this->sala = $sala;
    }*/

    public function setQuantidadeAlunos($quantidadeAlunos) {
        $this->quantidadeAlunos = $quantidadeAlunos;
    }

    public function setTurmas($turmas) {
        $this->turmas = $turmas;
    }

    public function setPeriodoCurso($periodoCurso) {
        $this->periodoCurso = $periodoCurso;
    }

    /*public function setDiaSemana($diaSemana) {
        $this->diaSemana = $diaSemana;
    }

    public function setEad($ead) {
        $this->ead = $ead;
    }*/

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

    public function setDsEad1($dsEad1) {
        $this->dsEad1 = $dsEad1;
    }

    public function setDsEad2($dsEad2) {
        $this->dsEad2 = $dsEad2;
    }

    //--------- SALAS ----------------------
    public function setDsSegSala($dsSegSala) {
        $this->dsSegSala = $dsSegSala;
    }

    public function setDsTerSala($dsTerSala) {
        $this->dsTerSala = $dsTerSala;
    }

    public function setDsQuaSala($dsQuaSala) {
        $this->dsQuaSala = $dsQuaSala;
    }

    public function setDsQuiSala($dsQuiSala) {
        $this->dsQuiSala = $dsQuiSala;
    }

    public function setDsSexSala($dsSexSala) {
        $this->dsSexSala = $dsSexSala;
    }

    public function setDsSabSala($dsSabSala) {
        $this->dsSabSala = $dsSabSala;
    }

    /*public function setDsEad1Sala($dsEad1Sala) {
        $this->dsEad1Sala = $dsEad1Sala;
    }

    public function setDsEad2Sala($dsEad2Sala) {
        $this->dsEad2Sala = $dsEad2Sala;
    }*/

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

    public function setCursoGrau($cursoGrau) {
        $this->cursoGrau = $cursoGrau;
    }

    public function setGradeSemestralAno($gradeSemestralAno) {
        $this->gradeSemestralAno = $gradeSemestralAno;
    }

    public function setGradeSemestralSemestre($gradeSemestralSemestre) {
        $this->gradeSemestralSemestre = $gradeSemestralSemestre;
    }

    public function setGradeSemestralCurso($gradeSemestralCurso) {
        $this->gradeSemestralCurso = $gradeSemestralCurso;
    }

    public function setGradeSemestralId($gradeSemestralId) {
        $this->gradeSemestralId = $gradeSemestralId;
    }

    public function setGradeSemestralHorario($gradeSemestralHorario) {
        $this->gradeSemestralHorario = $gradeSemestralHorario;
    }

    public function setVerificaArray($verificaArray) {
        $this->verificaArray = $verificaArray;
    }

    //--------- PROFESSORES ----------------------
    public function setDsSegProf($dsSegProf) {
        $this->dsSegProf = $dsSegProf;
    }

    public function setDsTerProf($dsTerProf) {
        $this->dsTerProf = $dsTerProf;
    }

    public function setDsQuaProf($dsQuaProf) {
        $this->dsQuaProf = $dsQuaProf;
    }

    public function setDsQuiProf($dsQuiProf) {
        $this->dsQuiProf = $dsQuiProf;
    }

    public function setDsSexProf($dsSexProf) {
        $this->dsSexProf = $dsSexProf;
    }

    public function setDsSabProf($dsSabProf) {
        $this->dsSabProf = $dsSabProf;
    }

    public function setDsEad1Prof($dsEad1Prof) {
        $this->dsEad1Prof = $dsEad1Prof;
    }

    public function setDsEad2Prof($dsEad2Prof) {
        $this->dsEad2Prof = $dsEad2Prof;
    }

}
