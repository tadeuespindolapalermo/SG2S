<?php
ob_start();
class MatrizDao implements Dao {

    /*
     * Método para inserir uma nova matriz no sistema (disciplina) (controller)
     **/
    public function inserir($conn, $matriz) {

        $matriz_existe = false;

        // VERIFICA SE O NOME DA MATRIZ INFORMADA EXISTE NO SISTEMA
        $sqlMatriz = "SELECT * FROM matriz_curricular WHERE nome_matriz = :nomeMatriz";
        $selectMatriz = $conn->prepare($sqlMatriz);
        $selectMatriz->bindValue(':nomeMatriz', $matriz->getNomeMatriz());
        $selectMatriz->execute();

        if ($selectMatriz->rowCount() >= 1) {
            $dados_matriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_matriz as $dados)
                $matriz_existe = isset($dados["nome_matriz"]);

        } else {
            //echo 'Erro ao tentar localizar o registro da matriz!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($matriz_existe) {

            $retorno_get = '';

            if ($matriz_existe) {
                $retorno_get.= "erro_nome=1&";
            }

            header('Location: ../view/view_admin.php?pagina=view_form_matriz_cadastro.php&' . $retorno_get);
            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DE CURSO COM PDO
        try {
            $sqlMatriz = "INSERT INTO matriz_curricular(curso_idcurso, nome_matriz, carga_horaria, credito) VALUES (?, ?, ?, ?)";

            $stmtCreateMatriz = $conn->prepare($sqlMatriz);

            $idCurso = $matriz->getCursoIdCurso();
            $nomeMatriz = $matriz->getNomeMatriz();
            $cargaHoraria = $matriz->getCargaHoraria();
            $credito = $matriz->getCredito();

            $stmtCreateMatriz->bindParam(1, $idCurso, PDO::PARAM_INT, 11);
            $stmtCreateMatriz->bindParam(2, $nomeMatriz, PDO::PARAM_STR, 100);
            $stmtCreateMatriz->bindParam(3, $cargaHoraria, PDO::PARAM_STR, 5);
            $stmtCreateMatriz->bindParam(4, $credito, PDO::PARAM_INT, 1);

            $cadastroMatrizEfetuado = $stmtCreateMatriz->execute();

            return $cadastroMatrizEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para remover um curso do sistema (controller)
     **/
    public function remover($conn, $idMatrizCurricular) {
        // REMOÇÃO DA MATRIZ COM PDO
        try {
            $sqlIdMatriz = "DELETE FROM matriz_curricular WHERE idmatriz_curricular = :idMatrizCurricular";
            $selectIdMatriz = $conn->prepare($sqlIdMatriz);
            $selectIdMatriz->bindValue(':idMatrizCurricular', $idMatrizCurricular);
            $selectIdMatriz->execute();

            $linhas = $selectIdMatriz->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar uma matriz do sistema (controller)
     **/
    public function atualizar($conn, $matriz) {
        try {
            // UPDATE DA MATRIZ
            $strSqlMatriz = "
            UPDATE matriz_curricular set
                curso_idcurso = :cursoIdCurso,
                nome_matriz = :nomeMatriz,
                carga_horaria = :cargaHoraria,
                credito = :credito
            WHERE
                idmatriz_curricular = :idMatriz";

            $stmtUpdateMatriz = $conn->prepare($strSqlMatriz);
            $stmtUpdateMatriz->bindValue(':cursoIdCurso', $matriz->getCursoIdCurso());
            $stmtUpdateMatriz->bindValue(':nomeMatriz', $matriz->getNomeMatriz());
            $stmtUpdateMatriz->bindValue(':cargaHoraria', $matriz->getCargaHoraria());
            $stmtUpdateMatriz->bindValue(':credito', $matriz->getCredito());
            $stmtUpdateMatriz->bindValue(':idMatriz', $matriz->getIdMatrizCurricular());

            $updateMatriz = $stmtUpdateMatriz->execute();

            return $updateMatriz;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }

    }

    /*
     * Método para listar todos as matrizes do sistema (view)
     **/
    public function listar($conn) {
        $strSqlMatrizJoinCurso = "SELECT * FROM matriz_curricular INNER JOIN curso ON matriz_curricular.curso_idcurso = curso.idcurso ORDER BY idmatriz_curricular";
        $selectMatrizJoinCurso = $conn->prepare($strSqlMatrizJoinCurso);
        $selectMatrizJoinCurso->execute();
        return $selectMatrizJoinCurso;
    }

    /*
     * Método para listar todos os cursos do sistema no combobox de cadastro de matriz (view)
     **/
    public function listarCombo($conn) {
        $strSqlMatriz = "SELECT * FROM curso";
        $selectMatriz = $conn->prepare($strSqlMatriz);
        $selectMatriz->execute();
        return $selectMatriz;
    }

    /*
     * Método para popular a view de update de matriz (view)
     **/
    public function buscarPorId($conn, $idMatrizCurricular) {
        $strSqlMatriz = "SELECT * FROM matriz_curricular INNER JOIN curso WHERE idmatriz_curricular = :idMatrizCurricular";
        $selectMatriz = $conn->prepare($strSqlMatriz);
        $selectMatriz->bindValue(':idMatrizCurricular', $idMatrizCurricular);
        $selectMatriz->execute();
        return $selectMatriz;
    }

    // -----------------------------------------------------------------------------------
    // Métodos da Paginação
    /*
     * Método para listar todas as matrizes do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlMatriz = "SELECT * FROM matriz_curricular INNER JOIN curso ON matriz_curricular.curso_idcurso = curso.idcurso ORDER BY idmatriz_curricular ASC LIMIT ".$inicio. ", ". $limite;
        $selectMatriz = $conn->prepare($strSqlMatriz);
        $selectMatriz->execute();
        return $selectMatriz;
    }

    /*
     * Seleciona o id de todos os registros de matriz (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlMatriz = "SELECT idmatriz_curricular FROM matriz_curricular";
        $selectMatriz = $conn->prepare($strSqlMatriz);
        $selectMatriz->execute();
        return $selectMatriz;
    }
    // -----------------------------------------------------------------------------------

}
