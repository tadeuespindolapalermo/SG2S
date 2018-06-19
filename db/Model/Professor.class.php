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

    // Métodos auxiliares
    function validarCPF($cpf = null) {
    	// Verifica se um número foi informado
    	if(empty($cpf)) {
    		return false;
            die();
    	}

    	// Elimina possivel mascara
    	$cpf = preg_replace("/[^0-9]/", "", $cpf);
    	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    	// Verifica se o numero de digitos informados é igual a 11
    	if (strlen($cpf) != 11) {
    		return false;
    	}
    	// Verifica se nenhuma das sequências invalidas abaixo
    	// foi digitada. Caso afirmativo, retorna falso
    	else if ($cpf == '00000000000' ||
    		$cpf == '11111111111' ||
    		$cpf == '22222222222' ||
    		$cpf == '33333333333' ||
    		$cpf == '44444444444' ||
    		$cpf == '55555555555' ||
    		$cpf == '66666666666' ||
    		$cpf == '77777777777' ||
    		$cpf == '88888888888' ||
    		$cpf == '99999999999') {
    		return false;
    	 // Calcula os digitos verificadores para verificar se o
    	 // CPF é válido
    	 } else {

    		for ($t = 9; $t < 11; $t++) {

    			for ($d = 0, $c = 0; $c < $t; $c++) {
    				$d += $cpf{$c} * (($t + 1) - $c);
    			}
    			$d = ((10 * $d) % 11) % 10;
    			if ($cpf{$c} != $d) {
    				return false;
    			}
    		}
    		return true;
    	}
    }

}
