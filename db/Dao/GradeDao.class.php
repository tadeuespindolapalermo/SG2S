<?php

class GradeDao implements Dao {

    public function inserir($conn, $grade) {

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
        $strSqlGrade = "SELECT * FROM grade_semestral";
        $selectGrade = $conn->prepare($strSqlGrade);
        $selectGrade->execute();
        return $selectGrade;
    }

}
