<?php

class Matriz {

    private $idMatrizCurricular;
    private $cursoIdCurso;
    private $cursoNome;
    private $nomeMatriz;
    private $cargaHoraria;
    private $credito;

    public function getIdMatrizCurricular() {
        return $this->idMatrizCurricular;
    }

    public function getCursoIdCurso() {
        return $this->cursoIdCurso;
    }

    public function getCursoNome() {
        return $this->cursoNome;
    }

    public function getNomeMatriz() {
        return $this->nomeMatriz;
    }

    public function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    public function getCredito() {
        return $this->credito;
    }

    public function setIdMatrizCurricular($idMatrizCurricular) {
        $this->idMatrizCurricular = $idMatrizCurricular;
    }

    public function setCursoIdCurso($cursoIdCurso) {
        $this->cursoIdCurso = $cursoIdCurso;
    }

    public function setCursoNome($cursoNome) {
        $this->cursoNome = $cursoNome;
    }

    public function setNomeMatriz($nomeMatriz) {
        $this->nomeMatriz = $nomeMatriz;
    }

    public function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
    }

    public function setCredito($credito) {
        $this->credito = $credito;
    }

}
