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
            (quantidade_alunos, turmas, periodo_curso,
             grade_semestral_idgrade_semestral, grade_semestral_curso_idcurso,
             dsSeg, dsTer, dsQua, dsQui, dsSex, dsSab, dsEad1, dsEad2, dsSegSala,
             dsTerSala, dsQuaSala, dsQuiSala, dsSexSala, dsSabSala)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtCreateGradeHoraria = $conn->prepare($sqlGradeHoraria);

            //$stmtCreateGradeHoraria->bindValue(1, $gradeHoraria->getSala(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(1, $gradeHoraria->getQuantidadeAlunos(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(2, $gradeHoraria->getTurmas(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(3, $gradeHoraria->getPeriodoCurso(), PDO::PARAM_INT);
            //$stmtCreateGradeHoraria->bindValue(5, $gradeHoraria->getDiaSemana(), PDO::PARAM_INT);
            //$stmtCreateGradeHoraria->bindValue(6, $gradeHoraria->getEad(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(4, $gradeHoraria->getIdGradeSemestral(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(5, $gradeHoraria->getIdCursoGradeSemestral(), PDO::PARAM_INT);
            $stmtCreateGradeHoraria->bindValue(6, $gradeHoraria->getDsSeg(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(7, $gradeHoraria->getDsTer(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(8, $gradeHoraria->getDsQua(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(9, $gradeHoraria->getDsQui(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(10, $gradeHoraria->getDsSex(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(11, $gradeHoraria->getDsSab(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(12, $gradeHoraria->getDsEad1(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(13, $gradeHoraria->getDsEad2(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(14, $gradeHoraria->getDsSegSala(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(15, $gradeHoraria->getDsTerSala(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(16, $gradeHoraria->getDsQuaSala(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(17, $gradeHoraria->getDsQuiSala(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(18, $gradeHoraria->getDsSexSala(), PDO::PARAM_STR);
            $stmtCreateGradeHoraria->bindValue(19, $gradeHoraria->getDsSabSala(), PDO::PARAM_STR);
            //$stmtCreateGradeHoraria->bindValue(23, $gradeHoraria->getDsEad1Prof(), PDO::PARAM_STR);
            //$stmtCreateGradeHoraria->bindValue(24, $gradeHoraria->getDsEad2Prof(), PDO::PARAM_STR);

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
        try {
            // UPDATE DA GRADE
            $strSqlGradeHoraria = "
            UPDATE grade_horaria set
                quantidade_alunos = :quantidadeAlunos,
                turmas = :turmas,
                periodo_curso = :periodoCurso,
                dsSeg = :disciplinaSeg,
                dsTer = :disciplinaTer,
                dsQua = :disciplinaQua,
                dsQui = :disciplinaQui,
                dsSex = :disciplinaSex,
                dsSab = :disciplinaSab,
                dsEad1 = :disciplinaEad1,
                dsEad2 = :disciplinaEad2,
                dsSegSala = :disciplinaSegSala,
                dsTerSala = :disciplinaTerSala,
                dsQuaSala = :disciplinaQuaSala,
                dsQuiSala = :disciplinaQuiSala,
                dsSexSala = :disciplinaSexSala,
                dsSabSala = :disciplinaSabSala
            WHERE
                idgrade_horaria = :idGradeHoraria";

            $stmtUpdateGradeHoraria = $conn->prepare($strSqlGradeHoraria);
            $stmtUpdateGradeHoraria->bindValue(':quantidadeAlunos', $gradeHoraria->getQuantidadeAlunos());
            $stmtUpdateGradeHoraria->bindValue(':turmas', $gradeHoraria->getTurmas());
            $stmtUpdateGradeHoraria->bindValue(':periodoCurso', $gradeHoraria->getPeriodoCurso());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSeg', $gradeHoraria->getDsSeg());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaTer', $gradeHoraria->getDsTer());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaQua', $gradeHoraria->getDsQua());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaQui', $gradeHoraria->getDsQui());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSex', $gradeHoraria->getDsSex());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSab', $gradeHoraria->getDsSab());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaEad1', $gradeHoraria->getDsEad1());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaEad2', $gradeHoraria->getDsEad2());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSegSala', $gradeHoraria->getDsSegSala());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaTerSala', $gradeHoraria->getDsTerSala());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaQuaSala', $gradeHoraria->getDsQuaSala());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaQuiSala', $gradeHoraria->getDsQuiSala());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSexSala', $gradeHoraria->getDsSexSala());
            $stmtUpdateGradeHoraria->bindValue(':disciplinaSabSala', $gradeHoraria->getDsSabSala());
            $stmtUpdateGradeHoraria->bindValue(':idGradeHoraria', $gradeHoraria->getIdGradeHoraria());

            $updateGradeHoraria = $stmtUpdateGradeHoraria->execute();

            return $updateGradeHoraria;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

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
    /*public function listarProfessorDisciplina($conn, $nomeDisciplina) {
        $strSqlGradeHoraria = "SELECT * FROM professor
        INNER JOIN disciplina_professor ON professor.idprofessor = disciplina_professor.professor_idprofessor
        INNER JOIN disciplinas ON disciplinas.iddisciplinas = disciplina_professor.disciplinas_iddisciplinas
        WHERE nome_disciplina = :nomeDisciplina";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':nomeDisciplina', $nomeDisciplina);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }*/

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
     * Método para listar todos as grades semestrais do sistema (view)
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
     * ...
     **/
    public function listarIdGradeSemestral($conn, $idGradeHoraria) {
        $strSqlGradeHoraria = "SELECT grade_semestral_idgrade_semestral FROM grade_horaria WHERE idgrade_horaria = :idGradeHoraria";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':idGradeHoraria', $idGradeHoraria);
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
     * Método para popular a o campo de curso da view de cadastro da grade horária (view)
     **/
    public function buscarGradeHorariaPorId($conn, $idGradeHoraria) {
        $strSqlGradeHoraria = "SELECT * FROM grade_horaria
        INNER JOIN grade_semestral ON grade_horaria.grade_semestral_idgrade_semestral = grade_semestral.idgrade_semestral
        WHERE idgrade_horaria = :idGradeHoraria";
        $selectGradeHoraria = $conn->prepare($strSqlGradeHoraria);
        $selectGradeHoraria->bindValue(':idGradeHoraria', $idGradeHoraria);
        $selectGradeHoraria->execute();
        return $selectGradeHoraria;
    }

    /*
     * Método para listar todos as disciplinas de um curso
     **/
    public function listarMatriz($conn, $idCurso) {
        $strSqlCursoMatriz = "SELECT * FROM disciplinas
                              INNER JOIN curso_disciplinas ON disciplinas.iddisciplinas = curso_disciplinas.disciplinas_iddisciplinas
                              INNER JOIN curso ON curso_disciplinas.curso_idcurso = curso.idcurso
                              INNER JOIN disciplina_professor ON disciplinas.iddisciplinas = disciplina_professor.disciplinas_iddisciplinas
                              INNER JOIN professor ON disciplina_professor.professor_idprofessor = professor.idprofessor
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
