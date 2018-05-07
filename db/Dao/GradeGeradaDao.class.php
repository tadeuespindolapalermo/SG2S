<?php

class GradeGeradaDao implements Dao {

    /*
     * Método para inserir uma nova grade gerada no sistema (controller)
     **/
    public function inserir($conn, $gradeGerada) {
        // INSERÇÃO DE GRADE COM PDO
        try {
            $sqlGradeGerada = "INSERT INTO grade_gerada
            (disciplinaSEG, disciplinaTER, disciplinaQUA, disciplinaQUI, disciplinaSEX, disciplinaSAB,
            disciplinaEAD, salaSEG, salaTER, salaQUA, salaQUI, salaSEX, salaSAB, salaEAD)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtCreateGradeGerada = $conn->prepare($sqlGradeGerada);

            $stmtCreateGradeGerada->bindValue(1, $gradeGerada->getDisciplinaSegunda(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(2, $gradeGerada->getDisciplinaTerca(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(3, $gradeGerada->getDisciplinaQuarta(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(4, $gradeGerada->getDisciplinaQuinta(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(5, $gradeGerada->getDisciplinaSexta(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(6, $gradeGerada->getDisciplinaSabado(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(7, $gradeGerada->getDisciplinaEad(), PDO::PARAM_STR);
            $stmtCreateGradeGerada->bindValue(8, $gradeGerada->getSalaSegunda(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(9, $gradeGerada->getSalaTerca(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(10, $gradeGerada->getSalaQuarta(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(11, $gradeGerada->getSalaQuinta(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(12, $gradeGerada->getSalaSexta(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(13, $gradeGerada->getSalaSabado(), PDO::PARAM_INT);
            $stmtCreateGradeGerada->bindValue(14, $gradeGerada->getSalaEad(), PDO::PARAM_INT);

            $cadastroGradeGeradaEfetuado = $stmtCreateGradeGerada->execute();

            return $cadastroGradeGeradaEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover uma grade gerada do sistema (controller)
     **/
    public function remover($conn, $idGradeGerada) {
        // REMOÇÃO DA GRADE COM PDO
        try {
            $sqlIdGradeGerada = "DELETE FROM grade_gerada WHERE idgrade_gerada = :idGradeGerada";
            $selectIdGradeGerada = $conn->prepare($sqlIdGradeGerada);
            $selectIdGradeGerada->bindValue(':idGradeGerada', $idGradeGerada);
            $selectIdGradeGerada->execute();

            $linhas = $selectIdGradeGerada->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma grade do sistema (controller)
     **/
    public function atualizar($conn, $grade) {
        /*try {

            $strSqlGrade = "
            UPDATE grade_semestral set
                ano_letivo = :anoLetivo,
                semestre = :semestre,
                periodo = :periodo,
                horario = :horario,
                sala = :sala,
                quantidade_alunos = :quantidadeAlunos,
                turmas = :turmas,
                curso_idcurso = :cursoIdCurso
            WHERE
                idgrade_semestral = :idGradeSemestral";

            $stmtUpdateGrade = $conn->prepare($strSqlGrade);
            $stmtUpdateGrade->bindValue(':anoLetivo', $grade->getAnoLetivo());
            $stmtUpdateGrade->bindValue(':semestre', $grade->getSemestre());
            $stmtUpdateGrade->bindValue(':periodo', $grade->getPeriodo());
            $stmtUpdateGrade->bindValue(':horario', $grade->getHorario());
            $stmtUpdateGrade->bindValue(':sala', $grade->getSala());
            $stmtUpdateGrade->bindValue(':quantidadeAlunos', $grade->getQuantidadeAlunos());
            $stmtUpdateGrade->bindValue(':turmas', $grade->getTurmas());
            $stmtUpdateGrade->bindValue(':cursoIdCurso', $grade->getCursoIdCurso());
            $stmtUpdateGrade->bindValue(':idGradeSemestral', $grade->getIdGradeSemestral());

            $updateGrade = $stmtUpdateGrade->execute();

            return $updateGrade;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }*/

    }

    /*
     * Método para listar todos as grades geradas do sistema (view)
     **/
    public function listar($conn) {
        $strSqlGradeGerada = "SELECT * FROM grade_gerada";
        $selectGradeGerada = $conn->prepare($strSqlGradeGerada);
        $selectGradeGerada->execute();
        return $selectGradeGerada;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de grade (view)
     **/
    /*public function listarCombo($conn) {
        $strSqlGrade = "SELECT * FROM curso";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->execute();
        return $selectGrade;
    }*/

    /*
     * Método para popular a view de update da grade (view)
     **/
    /*public function buscarPorId($conn, $idGrade) {
        $strSqlGrade = "SELECT * FROM grade_semestral WHERE idgrade_semestral = :idGradeSemestral";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->bindValue(':idGradeSemestral', $idGrade);
        $selectGrade->execute();
        return $selectGrade;
    }*/

}
