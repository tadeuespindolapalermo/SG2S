<?php
ob_start();
class GradeGeradaDao implements Dao {

    /*
     * Método para inserir uma nova grade gerada no sistema (controller)
     **/
    public function inserir($conn, $gradeGerada) {
        // INSERÇÃO DE GRADE GERADA COM PDO
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
     * Método para atualizar uma grade gerada do sistema (controller)
     **/
    public function atualizar($conn, $grade) {
        // ...
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
     * ...
     **/
    public function listarProfessor($conn) {
        $strSqlGradeGerada = "SELECT professor_idprofessor FROM disciplina_professor INNER JOIN matriz_curricular WHERE matriz_curricular_idmatriz_curricular = idmatriz_curricular";
        $selectGradeGerada = $conn->prepare($strSqlGradeGerada);
        $selectGradeGerada->execute();
        return $selectGradeGerada;
    }

}
