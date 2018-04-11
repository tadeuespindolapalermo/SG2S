<?php

class CursoDao implements Dao {

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
            echo 'Erro ao tentar localizar o registro do curso!';
        }
        // -------------------------------------------------------------

        if ($curso_existe) {

            $retorno_get = '';

            if ($curso_existe) {
                $retorno_get.= "erro_nome=1&";
            }

            header('Location: ../view/view_admin.php?pagina=view_form_curso_cadastro.php&' . $retorno_get);
            die();
        }

        // -------------------------------------------------------------

        // INSERÇÃO DE CURSO COM PDO
        try {
            $sqlCurso = "INSERT INTO curso(nome, portaria, duracao, grau, data_portaria) VALUES (?, ?, ?, ?, ?)";

            $stmtCreateCurso = $conn->prepare($sqlCurso);

            $stmtCreateCurso->bindParam(1, $curso->getNome(), PDO::PARAM_STR, 60);
            $stmtCreateCurso->bindParam(2, $curso->getPortaria(), PDO::PARAM_STR, 30);
            $stmtCreateCurso->bindParam(3, $curso->getDuracao(), PDO::PARAM_STR, 02);
            $stmtCreateCurso->bindParam(4, $curso->getGrau(), PDO::PARAM_STR, 30);
            $stmtCreateCurso->bindParam(5, $curso->getDataPortaria(), PDO::PARAM_STR, 10);

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
     * Método para atualizar um curso do sistema (controller
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
                data_portaria = :dataPortaria
            WHERE
                idcurso = :idCurso";

            $stmtUpdateCurso = $conn->prepare($strSqlCurso);
            $stmtUpdateCurso->bindValue(':nome', $curso->getNome());
            $stmtUpdateCurso->bindValue(':portaria', $curso->getPortaria());
            $stmtUpdateCurso->bindValue(':duracao', $curso->getDuracao());
            $stmtUpdateCurso->bindValue(':grau', $curso->getGrau());
            $stmtUpdateCurso->bindValue(':dataPortaria', $curso->getDataPortaria());
            $stmtUpdateCurso->bindValue(':idCurso', $curso->getIdCurso());
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
        $strSqlCurso = "SELECT * FROM curso";
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

}
