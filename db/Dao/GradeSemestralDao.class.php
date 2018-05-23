<?php
ob_start();
class GradeSemestralDao implements Dao {

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
     * Método para inserir uma nova grade semestral no sistema (controller)
     **/
    public function inserir($conn, $gradeSemestral) {

        $ano_existe = false;
        $semestre_existe = false;
        $curso_existe = false;

        // VERIFICA SE A GRADE INFORMADA JÁ EXISTE - TRINCA: ANO, SEMESTRE  E CURSO
        $sql = "SELECT ano_letivo, semestre_letivo, curso_idcurso FROM grade_semestral
                WHERE ano_letivo = :anoLetivo
                AND semestre_letivo = :semestreLetivo
                AND curso_idcurso = :idCurso";
        $select = $conn->prepare($sql);
        $select->bindValue(':anoLetivo', $gradeSemestral->getAnoLetivo());
        $select->bindValue(':semestreLetivo', $gradeSemestral->getSemestreLetivo());
        $select->bindValue(':idCurso', $gradeSemestral->getCursoIdCurso());
        $select->execute();

        if ($select->rowCount() >= 1) {
            $dadosSelect = $select->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dadosSelect as $dados)
                $ano_existe = isset($dados["ano_letivo"]);
                $semestre_existe = isset($dados["semestre_letivo"]);
                $curso_existe = isset($dados["curso_idcurso"]);
        } else {
            //echo 'Erro ao tentar efetuar a consulta da grade!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($ano_existe && $semestre_existe && $curso_existe) {

            $retorno_get = '';

            if ($ano_existe) {
                $retorno_get.= "erro_ano=1&";
            }

            if ($semestre_existe) {
                $retorno_get.= "erro_semestre=1&";
            }

            if ($curso_existe) {
                $retorno_get.= "erro_curso=1&";
            }

            header('Location: ../view/'.$this->verificarUrl().'?pagina=view_form_grade_semestral_cadastro.php&' . $retorno_get);
            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DE GRADE COM PDO
        try {
            $sqlGradeSemestral = "INSERT INTO grade_semestral(ano_letivo, semestre_letivo, turno, horario, curso_idcurso) VALUES (?, ?, ?, ?, ?)";

            $stmtCreateGradeSemestral = $conn->prepare($sqlGradeSemestral);

            $anoLetivo = $gradeSemestral->getAnoLetivo();
            $semestreLetivo = $gradeSemestral->getSemestreLetivo();
            $turno = $gradeSemestral->getTurno();
            $horario = $gradeSemestral->getHorario();
            $cursoIdCurso = $gradeSemestral->getCursoIdCurso();

            $stmtCreateGradeSemestral->bindParam(1, $anoLetivo , PDO::PARAM_INT, 4);
            $stmtCreateGradeSemestral->bindParam(2, $semestreLetivo, PDO::PARAM_INT, 1);
            $stmtCreateGradeSemestral->bindParam(3, $turno, PDO::PARAM_STR, 12);
            $stmtCreateGradeSemestral->bindParam(4, $horario, PDO::PARAM_STR, 30);
            $stmtCreateGradeSemestral->bindParam(5, $cursoIdCurso, PDO::PARAM_INT, 11);

            $cadastroGradeSemestralEfetuado = $stmtCreateGradeSemestral->execute();

            return $cadastroGradeSemestralEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover uma grade semestral do sistema (controller)
     **/
    public function remover($conn, $idGradeSemestral) {
        // REMOÇÃO DA GRADE COM PDO
        try {
            $sqlIdGradeSemestral = "DELETE FROM grade_semestral WHERE idgrade_semestral = :idGradeSemestral";
            $selectIdGradeSemestral = $conn->prepare($sqlIdGradeSemestral);
            $selectIdGradeSemestral->bindValue(':idGradeSemestral', $idGradeSemestral);
            $selectIdGradeSemestral->execute();

            $linhas = $selectIdGradeSemestral->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma grade semestral do sistema (controller)
     **/
    public function atualizar($conn, $gradeSemestral) {
        try {
            // UPDATE DA GRADE
            $strSqlGradeSemestral = "
            UPDATE grade_semestral set
                ano_letivo = :anoLetivo,
                semestre_letivo = :semestreLetivo,
                turno = :turno,
                horario = :horario,
                curso_idcurso = :cursoIdCurso
            WHERE
                idgrade_semestral = :idGradeSemestral";

            $stmtUpdateGradeSemestral = $conn->prepare($strSqlGradeSemestral);
            $stmtUpdateGradeSemestral->bindValue(':anoLetivo', $gradeSemestral->getAnoLetivo());
            $stmtUpdateGradeSemestral->bindValue(':semestreLetivo', $gradeSemestral->getSemestreLetivo());
            $stmtUpdateGradeSemestral->bindValue(':turno', $gradeSemestral->getTurno());
            $stmtUpdateGradeSemestral->bindValue(':horario', $gradeSemestral->getHorario());
            $stmtUpdateGradeSemestral->bindValue(':cursoIdCurso', $gradeSemestral->getCursoIdCurso());
            $stmtUpdateGradeSemestral->bindValue(':idGradeSemestral', $gradeSemestral->getIdGradeSemestral());

            /**
              * CÓDIGO DE DEBUG DO PROBLEMA DO UPDATE QUE FOI RESOLVIDO
              */
            /*echo '<pre>';
            echo 'Ano Letivo: ';
            print_r($gradeSemestral->getAnoLetivo() . '<br>');
            echo 'Semestre: ';
            print_r($gradeSemestral->getSemestre() . '<br>');
            echo 'Período: ';
            print_r($gradeSemestral->getPeriodo() . '<br>');
            echo 'Horário: ';
            print_r($gradeSemestral->getHorario() . '<br>');
            echo 'Sala: ';
            print_r($gradeSemestral->getSala() . '<br>');
            echo 'Quantidade Alunos: ';
            print_r($gradeSemestral->getQuantidadeAlunos() . '<br>');
            echo 'Turmas: ';
            print_r($gradeSemestral->getTurmas() . '<br>');
            echo 'Curso Id Curso: ';
            print_r($gradeSemestral->getCursoIdCurso() . '<br>');
            echo 'Id Grade Semestral: ';
            print_r($gradeSemestral->getIdGradeSemestral() . '<br>');
            echo '</pre>';

            exit();*/
            $updateGradeSemestral = $stmtUpdateGradeSemestral->execute();

            return $updateGradeSemestral;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para listar todos as grades semestrais do sistema (view)
     **/
    public function listar($conn) {
        $strSqlGradeSemestralJoinCurso = "SELECT * FROM grade_semestral INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso ORDER BY idgrade_semestral";
        $selectGradeSemestralJoinCurso = $conn->prepare($strSqlGradeSemestralJoinCurso);
        $selectGradeSemestralJoinCurso->execute();
        return $selectGradeSemestralJoinCurso;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de grade semestral (view)
     **/
    public function listarCombo($conn) {
        $strSqlGradeSemestral = "SELECT * FROM curso";
        $selectGradeSemestral = $conn->prepare($strSqlGradeSemestral);
        $selectGradeSemestral->execute();
        return $selectGradeSemestral;
    }

    /*
     * Método para popular a view de update da grade semestral (view)
     **/
    public function buscarPorId($conn, $idGradeSemestral) {
        $strSqlGradeSemestral = "SELECT * FROM grade_semestral INNER JOIN curso ON grade_semestral.idgrade_semestral = curso.idcurso WHERE idgrade_semestral = :idGradeSemestral";
        $selectGradeSemestral = $conn->prepare($strSqlGradeSemestral);
        $selectGradeSemestral->bindValue(':idGradeSemestral', $idGradeSemestral);
        $selectGradeSemestral->execute();
        return $selectGradeSemestral;
    }

    // -----------------------------------------------------------------------------------
    // Métodos da Paginação
    /*
     * Método para listar todos as grades semestrais do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlGradeSemestral = "SELECT * FROM grade_semestral INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso ORDER BY idgrade_semestral ASC LIMIT ".$inicio. ", ". $limite;
        $selectGradeSemestral = $conn->prepare($strSqlGradeSemestral);
        $selectGradeSemestral->execute();
        return $selectGradeSemestral;
    }

    /*
     * Seleciona o id de todos os registros de grade semestral (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlGradeSemestral = "SELECT idgrade_semestral FROM grade_semestral";
        $selectGradeSemestral = $conn->prepare($strSqlGradeSemestral);
        $selectGradeSemestral->execute();
        return $selectGradeSemestral;
    }
    // -----------------------------------------------------------------------------------

}
