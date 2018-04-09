<?php
    session_start();

    require('../db/Config.inc.php');

    $curso = new Curso();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    $curso->setNome($_POST['nome']);
    $curso->setPortaria($_POST['portaria']);
    $curso->setDuracao($_POST['duracao']);
    $curso->setGrau($_POST['grau']);
    $curso->setDataPortaria($_POST['dataPortaria']);

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

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

    // --------------------------------------------------

    // INSERÇÃO DE USUÁRIO COM PDO
    try {
        $sqlCurso = "INSERT INTO curso(nome, portaria, duracao, grau, data_portaria) VALUES (?, ?, ?, ?, ?)";

        $stmtCreateCurso = $conn->prepare($sqlCurso);

        $stmtCreateCurso->bindParam(1, $curso->getNome(), PDO::PARAM_STR, 60);
        $stmtCreateCurso->bindParam(2, $curso->getPortaria(), PDO::PARAM_STR, 30);
        $stmtCreateCurso->bindParam(3, $curso->getDuracao(), PDO::PARAM_STR, 02);
        $stmtCreateCurso->bindParam(4, $curso->getGrau(), PDO::PARAM_STR, 30);
        $stmtCreateCurso->bindParam(5, $curso->getDataPortaria(), PDO::PARAM_STR, 10);

        $cadastroCursoEfetuado = $stmtCreateCurso->execute();
        // -----------------------------------------

        // VALIDAÇÃO DA INSERÇÃO DO USUÁRIO E DO PERFIL
        if($cadastroCursoEfetuado) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Curso cadastrado com sucesso!!!\");
            </script>";
            header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao cadastrar curso!!!\");
            </script>";
            header('Location: ../view/view_admin.php?pagina=view_form_curso_cadastro.php');
        }
    } catch (PDOException $e) {
        PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
    }
