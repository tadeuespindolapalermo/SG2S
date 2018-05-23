<?php
ob_start();
class GradeGeradaDao implements Dao {

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
     * Método para inserir uma nova grade horária no sistema (controller)
     **/
    public function inserir($conn, $gradeHoraria) {
        // INSERÇÃO DE GRADE HORÁRIA COM PDO
        try {
            $sqlGradeHoraria = "INSERT INTO grade_horaria
            (sala, quantidade_alunos, turmas, periodo_curso, dia_semana, ead,
             grade_semestral_idgrade_semestral, grade_semestral_curso_idcurso)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtCreateGradeHoraria = $conn->prepare($sqlGradeHoraria);

            $stmtCreateGradeHoraria->bindValue(1, $gradeHoraria->getSala(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(2, $gradeHoraria->getQuantidadeAlunos(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(3, $gradeHoraria->getTurmas(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(4, $gradeHoraria->getPeriodoCurso(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(5, $gradeHoraria->getDiaSemana(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(6, $gradeHoraria->getEad(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(7, $gradeHoraria->getIdGradeSemestral(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(8, $gradeHoraria->getIdCursoGradeSemestral(), PDO::PARAM_INT);

            $cadastroGradeHorariaEfetuado = $stmtCreateGradeHoraria->execute();

            return $cadastroGradeHorariaEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover uma grade horária do sistema (controller)
     **/
    public function remover($conn, $idGradeHoraria) {
        // REMOÇÃO DA GRADE COM PDO
        try {
            $sqlIdGradeHoraria = "DELETE FROM grade_horaria WHERE idgrade_horaria = :idGradeHoraria";
            $selectIdGradeHoraria = $conn->prepare($sqlIdGradeHoraria);
            $selectIdGradeHoraria->bindValue(':idGradeHoraria', $idGradeHoraria);
            $selectIdGradeHoraria->execute();

            $linhas = $selectIdGradeHoraria->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma grade horária do sistema (controller)
     **/
    public function atualizar($conn, $grade) {
        // ...
    }

    /*
     * Método para listar todos as grades horárias do sistema (view)
     **/
    public function listar($conn) {
        $strSqlGradeHoraria = "SELECT * FROM grade_horaria";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * ...
     **/
    public function listarProfessor($conn) {
        $strSqlGradeHoraria = "SELECT professor_idprofessor FROM disciplina_professor INNER JOIN disciplinas WHERE disciplinas_iddisciplinas = iddisciplinas";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

}
