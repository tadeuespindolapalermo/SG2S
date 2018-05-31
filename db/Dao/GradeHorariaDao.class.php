<?php
ob_start();
class GradeHorariaDao implements Dao {

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
             grade_semestral_idgrade_semestral, grade_semestral_curso_idcurso,
             dsSeg, dsTer, dsQua, dsQui, dsSex, dsSab, dsEad, dsSegProf, dsTerProf,
             dsQuaProf, dsQuiProf, dsSexProf, dsSabProf, dsEadProf)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtCreateGradeHoraria = $conn->prepare($sqlGradeHoraria);

            $stmtCreateGradeHoraria->bindValue(1, $gradeHoraria->getSala(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(2, $gradeHoraria->getQuantidadeAlunos(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(3, $gradeHoraria->getTurmas(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(4, $gradeHoraria->getPeriodoCurso(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(5, $gradeHoraria->getDiaSemana(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(6, $gradeHoraria->getEad(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(7, $gradeHoraria->getIdGradeSemestral(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(8, $gradeHoraria->getIdCursoGradeSemestral(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(9, $gradeHoraria->getDsSeg(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(10, $gradeHoraria->getDsTer(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(11, $gradeHoraria->getDsQua(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(12, $gradeHoraria->getDsQui(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(13, $gradeHoraria->getDsSex(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(14, $gradeHoraria->getDsSab(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(15, $gradeHoraria->getDsEad(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(16, $gradeHoraria->getDsSegProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(17, $gradeHoraria->getDsTerProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(18, $gradeHoraria->getDsQuaProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(19, $gradeHoraria->getDsQuiProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(20, $gradeHoraria->getDsSexProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(21, $gradeHoraria->getDsSabProf(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(22, $gradeHoraria->getDsEadProf(), PDO::PARAM_STR);

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
    public function atualizar($conn, $gradeHoraria) {
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
     * Método para listar o professor de determinada disciplina com base no nome da disciplina
     **/
    public function listarProfessorDisciplina($conn, $nomeDisciplina) {
        $strSqlGradeHoraria = "SELECT * FROM professor
        INNER JOIN disciplina_professor ON professor.idprofessor = disciplina_professor.professor_idprofessor
        INNER JOIN disciplinas ON disciplinas.iddisciplinas = disciplina_professor.disciplinas_iddisciplinas
        WHERE nome_disciplina = :nomeDisciplina";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':nomeDisciplina', $nomeDisciplina);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * Método para listar todos as grades horárias do sistema (view)
     **/
    public function listarPorGradeSemestral($conn, $idGradeSemestral) {
        $strSqlGradeHoraria = "SELECT * FROM grade_horaria
        INNER JOIN grade_semestral ON grade_horaria.grade_semestral_idgrade_semestral = grade_semestral.idgrade_semestral
        INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso
        WHERE grade_semestral_idgrade_semestral = :idGradeSemestral";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':idGradeSemestral', $idGradeSemestral);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * ...
     **/
    /*public function listarNomeProfessor($conn, $nomeDisciplina) {
        $strSqlGradeHoraria = "SELECT * FROM professor
        INNER JOIN disciplina_professor ON professor.idprofessor = disciplina_professor.professor_idprofessor
        INNER JOIN disciplina ON disciplina.iddisciplinas = disciplina_professor.disciplinas_iddisciplinas
        WHERE nome_disciplina = :nomeDisciplina";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':nomeDisciplina', $nomeDisciplina);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }*/

    /*
     * Método para listar todos as grades horárias do sistema (view)
     **/
    public function listarGradesSemestrais($conn) {
        $strSqlGradeHoraria = "SELECT * FROM grade_semestral
        INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de grade horária (view)
     **/
    public function listarComboCurso($conn) {
        $strSqlGradeHoraria = "SELECT * FROM curso";
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

    /*
     * Método para popular a o campo de curso da view de cadastro da grade horária (view)
     **/
    public function buscarPorId($conn, $idGradeSemestral) {
        $strSqlGradeHoraria = "SELECT * FROM grade_semestral
        INNER JOIN curso ON grade_semestral.curso_idcurso = curso.idcurso
        WHERE idgrade_semestral = :idGradeSemestral";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':idGradeSemestral', $idGradeSemestral);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * Método para listar todos as disciplinas de um curso
     **/
    public function listarMatriz($conn, $idCurso) {
        $strSqlCursoMatriz = "SELECT nome_disciplina, iddisciplinas FROM disciplinas
                              INNER JOIN curso_disciplinas ON disciplinas.iddisciplinas = curso_disciplinas.disciplinas_iddisciplinas
                              INNER JOIN curso ON curso_disciplinas.curso_idcurso = curso.idcurso
                              WHERE idcurso = :idCurso
                              ORDER BY nome_disciplina";
        $selectCursoMatriz = $conn->prepare($strSqlCursoMatriz);
        $selectCursoMatriz->bindValue(':idCurso', $idCurso);
        $selectCursoMatriz->execute();
        return $selectCursoMatriz;
    }

    // -----------------------------------------------------------------------------------
    // Métodos da Paginação
    /*
     * Método para listar todos as grades horarias do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlGradeHoraria = "SELECT * FROM grade_horaria
        INNER JOIN curso ON grade_horaria.grade_semestral_curso_idcurso = curso.idcurso
        INNER JOIN grade_semestral ON grade_horaria.grade_semestral_idgrade_semestral = grade_semestral.idgrade_semestral
        ORDER BY idgrade_horaria ASC LIMIT ".$inicio. ", ". $limite;
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * Seleciona o id de todos os registros de grade horária (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlGradeHoraria = "SELECT idgrade_horaria FROM grade_horaria";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }
    // -----------------------------------------------------------------------------------

}
