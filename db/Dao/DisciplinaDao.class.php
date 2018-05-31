<?php
ob_start();
class DisciplinaDao implements Dao {

    /*
     * Método que verifica o perfil do usuário logado e retorna a string de url correspondente
     **/
    public function verificarUrl() {
        if ($_SESSION['perfil_idperfil'] == 1) {
            $url = 'view_admin.php';
        } elseif ($_SESSION['perfil_idperfil'] == 2) {
            $url = 'view_coordenador.php';
        }
        return $url;
    }

    /*
     * Método para inserir uma nova disciplina no sistema (controller)
     **/
    public function inserir($conn, $disciplina) {

        $disciplina_existe = false;

        // VERIFICA SE O NOME DA DISCIPLINA INFORMADA EXISTE NO SISTEMA
        $sqlDisciplina = "SELECT * FROM disciplinas WHERE nome_disciplina = :nomeDisciplina";
        $selectDisciplina = $conn->prepare($sqlDisciplina);
        $selectDisciplina->bindValue(':nomeDisciplina', $disciplina->getNomeDisciplina());
        $selectDisciplina->execute();

        if ($selectDisciplina->rowCount() >= 1) {
            $dados_disciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_disciplina as $dados)
                $disciplina_existe = isset($dados["nome_disciplina"]);

        } else {
            //echo 'Erro ao tentar localizar o registro da disciplina!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($disciplina_existe) {

            $retorno_get = '';

            if ($disciplina_existe) {
                $retorno_get.= "erro_nome=1&";
            }

            header('Location: ../view/'.$this->verificarUrl().'?pagina=view_form_disciplina_cadastro.php&' . $retorno_get);
            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DA DISCIPLINA COM PDO
        try {
            $sqlDisciplina = "INSERT INTO disciplinas(nome_disciplina, carga_horaria, credito) VALUES (?, ?, ?)";

            $stmtCreateDisciplina = $conn->prepare($sqlDisciplina);

            $nomeDisciplina = $disciplina->getNomeDisciplina();
            $cargaHoraria = $disciplina->getCargaHoraria();
            $credito = $disciplina->getCredito();

            $stmtCreateDisciplina->bindParam(1, $nomeDisciplina, PDO::PARAM_STR, 100);
            $stmtCreateDisciplina->bindParam(2, $cargaHoraria, PDO::PARAM_STR, 5);
            $stmtCreateDisciplina->bindParam(3, $credito, PDO::PARAM_INT, 1);

            $cadastroDisciplinaEfetuado = $stmtCreateDisciplina->execute();

            return $cadastroDisciplinaEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para associar um Professor à uma disciplina (controller)
     **/
    public function associarProfessor($conn, $disciplina) {

        $professor_existe = false;
        $disciplina_existe = false;

        // VERIFICA SE A DISCIPLINA INFORMADA JÁ ESTÁ ASSOCIADO AO PROFESSOR ESCOLHIDA - PAR: PROFESSOR e DISCIPLINA
        $sql = "SELECT * FROM disciplina_professor
                WHERE professor_idprofessor = :idProfessor
                AND disciplinas_iddisciplinas = :idDisciplina";
        $select = $conn->prepare($sql);
        $select->bindValue(':idProfessor', $disciplina->getIdProfessorDisciplina());
        $select->bindValue(':idDisciplina', $disciplina->getIdDisciplina());
        $select->execute();

        if ($select->rowCount() >= 1) {
            $dadosSelect = $select->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dadosSelect as $dados)
                $professor_existe = isset($dados["professor_idprofessor"]);
                $disciplina_existe = isset($dados["disciplinas_iddisciplinas"]);
        } else {
            //echo 'Erro ao tentar efetuar a consulta da grade!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($professor_existe && $disciplina_existe) {

            $retorno_get = '';

            if ($professor_existe) {
                $retorno_get.= "erro_professor=1&";
            }

            if ($disciplina_existe) {
                $retorno_get.= "erro_disciplina=1&";
            }

            header('Location: ../view/'.$this->verificarUrl().'?pagina=view_form_professor_associar.php&idProfessor='.$disciplina->getIdProfessorDisciplina().'&' . $retorno_get);
            die();
        }


        // ASSOCIAÇÃO DE PROFESSOR E DISCIPLINA COM PDO
        try {
            $sqlDisciplinaProfessor = "INSERT INTO disciplina_professor(professor_idprofessor, disciplinas_iddisciplinas) VALUES (?, ?)";

            $stmtAssociaProfessor = $conn->prepare($sqlDisciplinaProfessor);

            $idProfessor = $disciplina->getIdProfessorDisciplina();
            $idDisciplina = $disciplina->getIdDisciplina();

            $stmtAssociaProfessor->bindParam(1, $idProfessor, PDO::PARAM_INT, 11);
            $stmtAssociaProfessor->bindParam(2, $idDisciplina, PDO::PARAM_INT, 11);

            $professorDisciplinaAssociado = $stmtAssociaProfessor->execute();

            return $professorDisciplinaAssociado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para associar um Curso à uma disciplina (controller)
     **/
    public function associarCurso($conn, $disciplina) {

        $curso_existe = false;
        $disciplina_existe = false;

        // VERIFICA SE A DISCIPLINA INFORMADA JÁ EXISTE NA MATRIZ - PAR: CURSO e DISCIPLINA
        $sql = "SELECT * FROM curso_disciplinas
                WHERE curso_idcurso = :idCurso
                AND disciplinas_iddisciplinas = :idDisciplina";
        $select = $conn->prepare($sql);
        $select->bindValue(':idCurso', $disciplina->getCursoIdCurso());
        $select->bindValue(':idDisciplina', $disciplina->getIdDisciplina());
        $select->execute();

        if ($select->rowCount() >= 1) {
            $dadosSelect = $select->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dadosSelect as $dados)
                $curso_existe = isset($dados["curso_idcurso"]);
                $disciplina_existe = isset($dados["disciplinas_iddisciplinas"]);
        } else {
            //echo 'Erro ao tentar efetuar a consulta da grade!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($curso_existe && $disciplina_existe) {

            $retorno_get = '';

            if ($curso_existe) {
                $retorno_get.= "erro_curso=1&";
            }

            if ($disciplina_existe) {
                $retorno_get.= "erro_disciplina=1&";
            }

            header('Location: ../view/'.$this->verificarUrl().'?pagina=view_form_curso_associar.php&idCurso='.$disciplina->getCursoIdCurso().'&' . $retorno_get);
            die();
        }

        // ASSOCIAÇÃO DE PROFESSOR E DISCIPLINA COM PDO
        try {
            $sqlDisciplinaCurso = "INSERT INTO curso_disciplinas(curso_idcurso, disciplinas_iddisciplinas) VALUES (?, ?)";

            $stmtAssociaCurso = $conn->prepare($sqlDisciplinaCurso);

            $idDisciplina = $disciplina->getIdDisciplina();
            $idCursoDisciplina = $disciplina->getCursoIdCurso();

            $stmtAssociaCurso->bindParam(1, $idCursoDisciplina, PDO::PARAM_INT, 11);
            $stmtAssociaCurso->bindParam(2, $idDisciplina, PDO::PARAM_INT, 11);

            $cursoDisciplinaAssociado = $stmtAssociaCurso->execute();

            return $cursoDisciplinaAssociado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para definir uma disciplina pré-requisito (controller)
     **/
    public function definirDisciplinaPreRequisito($conn, $disciplina) {
        // DEFINIÇÃO DE DISCIPLINA PRÉ-REQUISITO COM PDO
        try {
            $sqlDisciplinaPreRequisito = "INSERT INTO pre_requisito(disciplinas_iddisciplinas) VALUES (?)";

            $stmtDisciplinaPreRequisito = $conn->prepare($sqlDisciplinaPreRequisito);

            $idDisciplina = $disciplina->getIdDisciplina();

            $stmtDisciplinaPreRequisito->bindParam(1, $idDisciplina, PDO::PARAM_INT, 11);

            $disciplinaPreRequisitoDefinida = $stmtDisciplinaPreRequisito->execute();

            return $disciplinaPreRequisitoDefinida;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover uma disciplina do sistema (controller)
     **/
    public function remover($conn, $idDisciplina) {
        // REMOÇÃO DA DISCIPLINA COM PDO
        try {
            $sqlIdDisciplina = "DELETE FROM disciplinas WHERE iddisciplinas = :idDisciplina";
            $selectIdDisciplina = $conn->prepare($sqlIdDisciplina);
            $selectIdDisciplina->bindValue(':idDisciplina', $idDisciplina);
            $selectIdDisciplina->execute();

            $linhas = $selectIdDisciplina->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma disciplina do sistema (controller)
     **/
    public function atualizar($conn, $disciplina) {
        try {
            // UPDATE DA DISCIPLINA
            $strSqlDisciplina = "
            UPDATE disciplinas set
                nome_disciplina = :nomeDisciplina,
                carga_horaria = :cargaHoraria,
                credito = :credito
            WHERE
                iddisciplinas = :idDisciplina";

            $stmtUpdateDisciplina = $conn->prepare($strSqlDisciplina);
            $stmtUpdateDisciplina->bindValue(':nomeDisciplina', $disciplina->getNomeDisciplina());
            $stmtUpdateDisciplina->bindValue(':cargaHoraria', $disciplina->getCargaHoraria());
            $stmtUpdateDisciplina->bindValue(':credito', $disciplina->getCredito());
            $stmtUpdateDisciplina->bindValue(':idDisciplina', $disciplina->getIdDisciplina());

            $updateDisciplina = $stmtUpdateDisciplina->execute();

            return $updateDisciplina;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para listar todos as disciplinas do sistema (view)
     **/
    public function listar($conn) {
        $strSqlDisciplinaJoinCurso = "SELECT * FROM disciplinas ORDER BY nome_disciplina";
        $selectDisciplinaJoinCurso = $conn->prepare($strSqlDisciplinaJoinCurso);
        $selectDisciplinaJoinCurso->execute();
        return $selectDisciplinaJoinCurso;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de disciplina (view)
     **/
    public function listarCombo($conn) {
        $strSqlDisciplina = "SELECT * FROM curso";
        $selectDisciplina = $conn->prepare($strSqlDisciplina);
        $selectDisciplina->execute();
        return $selectDisciplina;
    }

    /*
     * Método para popular a view de update de disciplina (view)
     **/
    public function buscarPorId($conn, $idDisciplina) {
        $strSqlDisciplina = "SELECT * FROM disciplinas WHERE iddisciplinas = :idDisciplina";
        $selectDisciplina = $conn->prepare($strSqlDisciplina);
        $selectDisciplina->bindValue(':idDisciplina', $idDisciplina);
        $selectDisciplina->execute();
        return $selectDisciplina;
    }

    // -----------------------------------------------------------------------------------
    // Métodos da Paginação
    /*
     * Método para listar todas as disciplinas do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlDisciplina = "SELECT * FROM disciplinas ORDER BY nome_disciplina ASC LIMIT ".$inicio. ", ". $limite;
        $selectDisciplina = $conn->prepare($strSqlDisciplina);
        $selectDisciplina->execute();
        return $selectDisciplina;
    }

    /*
     * Seleciona o id de todos os registros de disciplina (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlDisciplina = "SELECT iddisciplinas FROM disciplinas";
        $selectDisciplina = $conn->prepare($strSqlDisciplina);
        $selectDisciplina->execute();
        return $selectDisciplina;
    }
    // -----------------------------------------------------------------------------------

}
