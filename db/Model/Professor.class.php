<?php

class Professor {

    // Atributos do Banco de Dados
    private $idProfessor;
    private $nome;
    private $CPF;
    private $RG;
    private $email;
    private $fone;
    private $exclusao; // pode ser NULL

    // Atributos auxiliares 29/05/18
    private $professorDisciplina;

    // Getters dos Atributos do Banco
    public function getIdProfessor() {
        return $this->idProfessor;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCPF() {
        return $this->CPF;
    }

    public function getRG() {
        return $this->RG;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFone() {
        return $this->fone;
    }

    public function getExclusao() {
        return $this->exclusao;
    }

    // Getters dos Atributos Auxiliares
    public function getProfessorDisciplina() {
        return $this->professorDisciplina;
    }

    // Setters dos Atributos do Banco
    public function setIdProfessor($idProfessor) {
        $this->idProfessor = $idProfessor;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCPF($CPF) {
        $this->CPF = $CPF;
    }

    public function setRG($RG) {
        $this->RG = $RG;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFone($fone) {
        $this->fone = $fone;
    }

    public function setExclusao($exclusao) {
        $this->exclusao = $exclusao;
    }

    // Setters dos Atributos Auxiliares
    public function setProfessorDisciplina($professorDisciplina) {
        $this->$professorDisciplina = $professorDisciplina;
    }

}
