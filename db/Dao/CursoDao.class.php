<?php
ob_start();
class CursoDao implements Dao {

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
     * Método para inserir um novo curso no sistema (controller)
     **/
    public function inserir($conn, $curso) {

        $curso_existe = false;

        // VERIFICA SE O NOME DO CURSO INFORMADO EXISTE NO SISTEMA
        $sqlCurso = "SELECT * FROM curso WHERE nome = :nome";
        $selectCurso = $conn->prepare($sqlCurso);
        $selectCurso->bindValue(':nome', $curso->getNome());
        $selectCurso->execute();

        if ($selectCurso->rowCount() >= 1) {
            $dados_curso = $selectCurso->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_curso as $dados)
                $curso_existe = isset($dados["nome"]);

        } else {
            //echo 'Erro ao tentar localizar o registro do curso!';
            echo '';
        }
        // -------------------------------------------------------------

        if ($curso_existe) {

            $retorno_get = '';

            if ($curso_existe) {
                $retorno_get.="erro_nome=1&";
            }

            header('Location: ../view/'.$this->verificarUrl().'?pagina=view_form_curso_cadastro.php&' . $retorno_get);

            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DE CURSO COM PDO
        try {
            $sqlCurso = "INSERT INTO curso(nome, portaria, duracao, grau, data_portaria, versao_matriz) VALUES (?, ?, ?, ?, ?, ?)";

            $stmtCreateCurso = $conn->prepare($sqlCurso);

            $nome = $curso->getNome();
            $portaria = $curso->getPortaria();
            $duracao = $curso->getDuracao();
            $grau = $curso->getGrau();
            $dataPortaria = $curso->getDataPortaria();
            $versaoMatriz = $curso->getVersaoMatriz();

            $stmtCreateCurso->bindParam(1, $nome, PDO::PARAM_STR, 60);
            $stmtCreateCurso->bindParam(2, $portaria, PDO::PARAM_STR, 30);
            $stmtCreateCurso->bindParam(3, $duracao, PDO::PARAM_STR, 02);
            $stmtCreateCurso->bindParam(4, $grau, PDO::PARAM_STR, 30);
            $stmtCreateCurso->bindParam(5, $dataPortaria, PDO::PARAM_STR, 10);
            $stmtCreateCurso->bindParam(6, $versaoMatriz, PDO::PARAM_INT, 5);

            $cadastroCursoEfetuado = $stmtCreateCurso->execute();

            return $cadastroCursoEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover um curso do sistema (controller)
     **/
    public function remover($conn, $idCurso) {
        // REMOÇÃO DO CURSO COM PDO
        try {
            $sqlIdCurso = "DELETE FROM curso WHERE idcurso = :idCurso";
            $selectIdCurso = $conn->prepare($sqlIdCurso);
            $selectIdCurso->bindValue(':idCurso', $idCurso);
            $selectIdCurso->execute();

            $linhas = $selectIdCurso->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar um curso do sistema (controller)
     **/
    public function atualizar($conn, $curso) {
        try {
            // UPDATE DO CURSO
            $strSqlCurso = "
            UPDATE curso set
                nome = :nome,
                portaria = :portaria,
                duracao = :duracao,
                grau = :grau,
                data_portaria = :dataPortaria,
                versao_matriz = :versaoMatriz
            WHERE
                idcurso = :idCurso";

            $stmtUpdateCurso = $conn->prepare($strSqlCurso);
            $stmtUpdateCurso->bindValue(':nome', $curso->getNome());
            $stmtUpdateCurso->bindValue(':portaria', $curso->getPortaria());
            $stmtUpdateCurso->bindValue(':duracao', $curso->getDuracao());
            $stmtUpdateCurso->bindValue(':grau', $curso->getGrau());
            $stmtUpdateCurso->bindValue(':dataPortaria', $curso->getDataPortaria());
            $stmtUpdateCurso->bindValue(':idCurso', $curso->getIdCurso());
            $stmtUpdateCurso->bindValue(':versaoMatriz', $curso->getVersaoMatriz());
            $updateCurso = $stmtUpdateCurso->execute();

            return $updateCurso;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para listar todos os cursos do sistema (view)
     **/
    public function listar($conn) {
        $strSqlCurso = "SELECT * FROM curso ORDER BY nome";
        $selectCurso = $conn->prepare($strSqlCurso);
        $selectCurso->execute();
        return $selectCurso;
    }

    /*
     * Método para popular a view de update de curso (view)
     **/
    public function buscarPorId($conn, $idCurso) {
        $strSqlCurso = "SELECT * FROM curso WHERE idcurso = :idCurso";
        $selectCurso = $conn->prepare($strSqlCurso);
        $selectCurso->bindValue(':idCurso', $idCurso);
        $selectCurso->execute();
        return $selectCurso;
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
     * Método para listar todos os cursos do sistema (view) ordenado por id de forma ascendente (PAGINAÇÃO)
     **/
    public function listarLimite($conn, $inicio, $limite) {
        // Seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
        $strSqlCurso = "SELECT * FROM curso ORDER BY nome ASC LIMIT ".$inicio. ", ". $limite;
        $selectCurso = $conn->prepare($strSqlCurso);
        $selectCurso->execute();
        return $selectCurso;
    }

    /*
     * Seleciona o id de todos os registros de curso (PAGINAÇÃO)
     **/
    public function listarId($conn) {
        $strSqlCurso = "SELECT idcurso FROM curso";
        $selectCurso = $conn->prepare($strSqlCurso);
        $selectCurso->execute();
        return $selectCurso;
    }
    // -----------------------------------------------------------------------------------

}
