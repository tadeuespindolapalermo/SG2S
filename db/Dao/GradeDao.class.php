<?php
ob_start();
class GradeDao implements Dao {

    /*
     * Método para inserir uma nova grade no sistema (controller)
     **/
    public function inserir($conn, $grade) {
        // INSERÇÃO DE GRADE COM PDO
        try {
            $sqlGrade = "INSERT INTO grade_semestral(ano_letivo, semestre_letivo, turno, horario, curso_idcurso) VALUES (?, ?, ?, ?, ?)";

            $stmtCreateGrade = $conn->prepare($sqlGrade);

            $anoLetivo = $grade->getAnoLetivo();
            $semestreLetivo = $grade->getSemestreLetivo();
            $turno = $grade->getTurno();
            $horario = $grade->getHorario();
            $cursoIdCurso = $grade->getCursoIdCurso();

            $stmtCreateGrade->bindParam(1, $anoLetivo , PDO::PARAM_INT, 4);
            $stmtCreateGrade->bindParam(2, $semestreLetivo, PDO::PARAM_INT, 1);
            $stmtCreateGrade->bindParam(3, $turno, PDO::PARAM_STR, 12);
            $stmtCreateGrade->bindParam(4, $horario, PDO::PARAM_STR, 30);
            $stmtCreateGrade->bindParam(5, $cursoIdCurso, PDO::PARAM_INT, 11);

            $cadastroGradeEfetuado = $stmtCreateGrade->execute();

            return $cadastroGradeEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover uma grade do sistema (controller)
     **/
    public function remover($conn, $idGrade) {
        // REMOÇÃO DA GRADE COM PDO
        try {
            $sqlIdGrade = "DELETE FROM grade_semestral WHERE idgrade_semestral = :idGrade";
            $selectIdGrade = $conn->prepare($sqlIdGrade);
            $selectIdGrade->bindValue(':idGrade', $idGrade);
            $selectIdGrade->execute();

            $linhas = $selectIdGrade->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma grade do sistema (controller)
     **/
    public function atualizar($conn, $grade) {
        try {
            // UPDATE DA GRADE
            $strSqlGrade = "
            UPDATE grade_semestral set
                ano_letivo = :anoLetivo,
                semestre_letivo = :semestreLetivo,
                turno = :turno,
                horario = :horario,
                curso_idcurso = :cursoIdCurso
            WHERE
                idgrade_semestral = :idGradeSemestral";

            $stmtUpdateGrade = $conn->prepare($strSqlGrade);
            $stmtUpdateGrade->bindValue(':anoLetivo', $grade->getAnoLetivo());
            $stmtUpdateGrade->bindValue(':semestreLetivo', $grade->getSemestreLetivo());
            $stmtUpdateGrade->bindValue(':turno', $grade->getTurno());
            $stmtUpdateGrade->bindValue(':horario', $grade->getHorario());            
            $stmtUpdateGrade->bindValue(':cursoIdCurso', $grade->getCursoIdCurso());
            $stmtUpdateGrade->bindValue(':idGradeSemestral', $grade->getIdGradeSemestral());

            /**
              * CÓDIGO DE DEBUG DO PROBLEMA DO UPDATE QUE FOI RESOLVIDO
              */
            /*echo '<pre>';
            echo 'Ano Letivo: ';
            print_r($grade->getAnoLetivo() . '<br>');
            echo 'Semestre: ';
            print_r($grade->getSemestre() . '<br>');
            echo 'Período: ';
            print_r($grade->getPeriodo() . '<br>');
            echo 'Horário: ';
            print_r($grade->getHorario() . '<br>');
            echo 'Sala: ';
            print_r($grade->getSala() . '<br>');
            echo 'Quantidade Alunos: ';
            print_r($grade->getQuantidadeAlunos() . '<br>');
            echo 'Turmas: ';
            print_r($grade->getTurmas() . '<br>');
            echo 'Curso Id Curso: ';
            print_r($grade->getCursoIdCurso() . '<br>');
            echo 'Id Grade Semestral: ';
            print_r($grade->getIdGradeSemestral() . '<br>');
            echo '</pre>';

            exit();*/
            $updateGrade = $stmtUpdateGrade->execute();

            return $updateGrade;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para listar todos as grades do sistema (view)
     **/
    public function listar($conn) {
        $strSqlGradeJoinCurso = "SELECT * FROM grade_semestral INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso ORDER BY idgrade_semestral";
        $selectGradeJoinCurso = $conn->prepare($strSqlGradeJoinCurso);
        $selectGradeJoinCurso->execute();
        return $selectGradeJoinCurso;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de grade (view)
     **/
    public function listarCombo($conn) {
        $strSqlGrade = "SELECT * FROM curso";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->execute();
        return $selectGrade;
    }

    /*
     * Método para popular a view de update da grade (view)
     **/
    public function buscarPorId($conn, $idGrade) {
        $strSqlGrade = "SELECT * FROM grade_semestral, curso WHERE grade_semestral.idgrade_semestral = curso.idcurso AND idgrade_semestral = :idGradeSemestral";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->bindValue(':idGradeSemestral', $idGrade);
        $selectGrade->execute();
        return $selectGrade;
    }

    // -----------------------------------------------------------------------------------
    // Métodos da Paginação
    /*
     * Método para listar todos as grades do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlGrade = "SELECT * FROM grade_semestral INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso ORDER BY idgrade_semestral ASC LIMIT ".$inicio. ", ". $limite;
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->execute();
        return $selectGrade;
    }

    /*
     * Seleciona o id de todos os registros de grade (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlGrade = "SELECT idgrade_semestral FROM grade_semestral";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->execute();
        return $selectGrade;
    }
    // -----------------------------------------------------------------------------------

}
