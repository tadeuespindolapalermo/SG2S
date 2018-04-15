<?php

class GradeDao implements Dao {

    /*
     * Método para inserir uma nova grade no sistema (controller)
     **/
    public function inserir($conn, $grade) {
        // INSERÇÃO DE GRADE COM PDO
        try {
            $sqlGrade = "INSERT INTO grade_semestral(ano_letivo, semestre, periodo, horario, sala, quantidade_alunos, turmas, curso_idcurso) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtCreateGrade = $conn->prepare($sqlGrade);

            $stmtCreateGrade->bindParam(1, $grade->getAnoLetivo(), PDO::PARAM_INT, 4);
            $stmtCreateGrade->bindParam(2, $grade->getSemestre(), PDO::PARAM_INT, 1);
            $stmtCreateGrade->bindParam(3, $grade->getPeriodo(), PDO::PARAM_STR, 12);
            $stmtCreateGrade->bindParam(4, $grade->getHorario(), PDO::PARAM_STR, 30);
            $stmtCreateGrade->bindParam(5, $grade->getSala(), PDO::PARAM_INT, 2);
            $stmtCreateGrade->bindParam(6, $grade->getQuantidadeAlunos(), PDO::PARAM_INT, 3);
            $stmtCreateGrade->bindParam(7, $grade->getTurmas(), PDO::PARAM_STR, 50);
            $stmtCreateGrade->bindParam(8, $grade->getCursoIdCurso(), PDO::PARAM_INT, 11);

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

    public function atualizar($conn, $grade) {

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

}
