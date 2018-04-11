<?php

class ProfessorDao implements Dao {

    /*
     * Método para inserir um novo professor no sistema (controller)
     **/
    public function inserir($conn, $professor) {

        $cpf_existe = false;
        $rg_existe = false;
        $email_existe = false;

        // VERIFICA SE O CPF DO PROFESSOR INFORMADO EXISTE NO SISTEMA
        $sqlCPF = "SELECT * FROM professor WHERE CPF = :cpf";
        $selectCPF = $conn->prepare($sqlCPF);
        $selectCPF->bindValue(':cpf', $professor->getCPF());
        $selectCPF->execute();

        if ($selectCPF->rowCount() >= 1) {
            $dados_cpf = $selectCPF->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_cpf as $dados)
                $cpf_existe = isset($dados["CPF"]);

        } else {
            echo 'Erro ao tentar localizar o registro do professor!';
        }
        // -------------------------------------------------------------

        // VERIFICA SE O RG DO PROFESSOR INFORMADO EXISTE NO SISTEMA
        $sqlRG = "SELECT * FROM professor WHERE RG = :rg";
        $selectRG = $conn->prepare($sqlRG);
        $selectRG->bindValue(':rg', $professor->getRG());
        $selectRG->execute();

        if ($selectRG->rowCount() >= 1) {
            $dados_rg = $selectRG->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_rg as $dados)
                $rg_existe = isset($dados["RG"]);

        } else {
            echo 'Erro ao tentar localizar o registro do professor!';
        }
        // -------------------------------------------------------------

        // VERIFICA SE O E-MAIL DO PROFESSOR INFORMADO EXISTE NO SISTEMA
        $sqlEmail = "SELECT * FROM professor WHERE email = :email";
        $selectEmail = $conn->prepare($sqlEmail);
        $selectEmail->bindValue(':email', $professor->getEmail());
        $selectEmail->execute();

        if ($selectEmail->rowCount() >= 1) {
            $dados_email = $selectEmail->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_email as $dados)
                $email_existe = isset($dados["email"]);

        } else {
            echo 'Erro ao tentar localizar o registro do professor!';
        }
        // -------------------------------------------------------------

    if ($cpf_existe || $rg_existe || $email_existe) {

            $retorno_get = '';

            if ($cpf_existe) {
                $retorno_get.= "erro_cpf=1&";
            }

            if ($rg_existe) {
                $retorno_get.= "erro_rg=1&";
            }

            if ($email_existe) {
                $retorno_get.= "erro_email=1&";
            }

            header('Location: ../view/view_admin.php?pagina=view_form_professor_cadastro.php&' . $retorno_get);
            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DE CURSO COM PDO
        try {
            $sqlProfessor = "INSERT INTO professor(nome, CPF, RG, email, fone, exclusao) VALUES (?, ?, ?, ?, ?, ?)";

            $stmtCreateProfessor = $conn->prepare($sqlProfessor);

            $stmtCreateProfessor->bindValue(1, $professor->getNome(), PDO::PARAM_STR);
            $stmtCreateProfessor->bindValue(2, $professor->getCPF(), PDO::PARAM_STR);
            $stmtCreateProfessor->bindValue(3, $professor->getRG(), PDO::PARAM_STR);
            $stmtCreateProfessor->bindValue(4, $professor->getEmail(), PDO::PARAM_STR);
            $stmtCreateProfessor->bindValue(5, $professor->getFone(), PDO::PARAM_STR);
            $stmtCreateProfessor->bindValue(6, $professor->getExclusao(), PDO::PARAM_INT);

            $cadastroProfessorEfetuado = $stmtCreateProfessor->execute();

            return $cadastroProfessorEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

     /*
      * Método para remover um professor do sistema (controller)
      * Lógica de negócio especial (REMOÇÃO FICTÍCIA)
      **/
     public function remover($conn, $idProfessor) {
        // REMOÇÃO DO PROFESSOR COM PDO
        try {
            // --------------------------------------------------------------------
            /* // EXCLUSÃO LEGÍTIMA
            $sqlIdProfessor = "DELETE FROM professor WHERE idprofessor = :idProfessor";
            $selectIdProfessor = $conn->prepare($sqlIdProfessor);
            $selectIdProfessor->bindValue(':idProfessor', $idProfessor);
            $selectIdProfessor->execute();

            $linhas = $selectIdProfessor->rowCount();

            return $linhas;*/
            // --------------------------------------------------------------------

            // --------------------------------------------------------------------
            // EXCLUSÃO FICTÍCIA, campo exclusao da tabela professor é setada com valor 0
            // Na view de listagem é renderizada somente os registros de professor com exclusao de valor 1
            // UPDATE DA COLUNA exclusao DA TABELA PROFESSOR
            $strSqlProfessor = "UPDATE professor set exclusao = :exclusao WHERE idprofessor = :idProfessor";

            $stmtUpdateProfessor = $conn->prepare($strSqlProfessor);
            $stmtUpdateProfessor->bindValue(':exclusao', 0);
            $stmtUpdateProfessor->bindValue(':idProfessor', $idProfessor);
            $updateProfessor = $stmtUpdateProfessor->execute();

            return $updateProfessor;
            // --------------------------------------------------------------------

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para atualizar um professor do sistema (controller)
     **/
    public function atualizar($conn, $professor) {
        try {
            // UPDATE DO CURSO
            $strSqlProfessor = "
            UPDATE professor set
                nome = :nome,
                CPF = :cpf,
                RG = :rg,
                email = :email,
                fone = :telefone
            WHERE
                idprofessor = :idProfessor";

            $stmtUpdateProfessor = $conn->prepare($strSqlProfessor);
            $stmtUpdateProfessor->bindValue(':nome', $professor->getNome());
            $stmtUpdateProfessor->bindValue(':cpf', $professor->getCPF());
            $stmtUpdateProfessor->bindValue(':rg', $professor->getRG());
            $stmtUpdateProfessor->bindValue(':email', $professor->getEmail());
            $stmtUpdateProfessor->bindValue(':telefone', $professor->getFone());
            $stmtUpdateProfessor->bindValue(':idProfessor', $professor->getIdProfessor());
            $updateProfessor = $stmtUpdateProfessor->execute();

            return $updateProfessor;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para listar todos os professores do sistema (view)
     **/
    public function listar($conn) {
        $strSqlProfessor = "SELECT * FROM professor WHERE exclusao != 0";
        $selectProfessor = $conn->prepare($strSqlProfessor);
        $selectProfessor->execute();
        return $selectProfessor;
    }

    /*
     * Método para popular a view de update do professor (view)
     **/
    public function buscarPorId($conn, $idProfessor) {
        $strSqlProfessor = "SELECT * FROM professor WHERE idprofessor = :idProfessor";
        $selectProfessor = $conn->prepare($strSqlProfessor);
        $selectProfessor->bindValue(':idProfessor', $idProfessor);
        $selectProfessor->execute();
        return $selectProfessor;
    }

}
