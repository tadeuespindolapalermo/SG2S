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

        // INSERÇÃO DE CURSO COM PDO
        try {
            $sqlDisciplina = "INSERT INTO disciplinas(curso_idcurso, nome_disciplina, carga_horaria, credito) VALUES (?, ?, ?, ?)";

            $stmtCreateDisciplina = $conn->prepare($sqlDisciplina);

            $idCurso = $disciplina->getCursoIdCurso();
            $nomeDisciplina = $disciplina->getNomeDisciplina();
            $cargaHoraria = $disciplina->getCargaHoraria();
            $credito = $disciplina->getCredito();

            $stmtCreateDisciplina->bindParam(1, $idCurso, PDO::PARAM_INT, 11);
            $stmtCreateDisciplina->bindParam(2, $nomeDisciplina, PDO::PARAM_STR, 100);
            $stmtCreateDisciplina->bindParam(3, $cargaHoraria, PDO::PARAM_STR, 5);
            $stmtCreateDisciplina->bindParam(4, $credito, PDO::PARAM_INT, 1);

            $cadastroDisciplinaEfetuado = $stmtCreateDisciplina->execute();

            return $cadastroDisciplinaEfetuado;
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
                curso_idcurso = :cursoIdCurso,
                nome_disciplina = :nomeDisciplina,
                carga_horaria = :cargaHoraria,
                credito = :credito
            WHERE
                iddisciplinas = :idDisciplina";

            $stmtUpdateDisciplina = $conn->prepare($strSqlDisciplina);
            $stmtUpdateDisciplina->bindValue(':cursoIdCurso', $disciplina->getCursoIdCurso());
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
        $strSqlDisciplinaJoinCurso = "SELECT * FROM disciplinas INNER JOIN curso ON disciplinas.curso_idcurso = curso.idcurso ORDER BY nome_disciplina";
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
        $strSqlDisciplina = "SELECT * FROM disciplinas INNER JOIN curso ON disciplinas.curso_idcurso = curso.idcurso WHERE iddisciplinas = :idDisciplina";
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
        $strSqlDisciplina = "SELECT * FROM disciplinas INNER JOIN curso ON disciplinas.curso_idcurso = curso.idcurso ORDER BY nome_disciplina ASC LIMIT ".$inicio. ", ". $limite;
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
