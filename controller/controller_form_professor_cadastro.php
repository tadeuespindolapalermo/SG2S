<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professor = new Professor();
    $professorDao = new ProfessorDao();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $professor->setNome($_POST['nome']);
    $professor->setCPF($_POST['cpf']);
    $professor->setRG($_POST['rg']);
    $professor->setEmail($_POST['email']);
    $professor->setFone($_POST['telefone']);
    $professor->setExclusao(1);

    // Inserção do Professor no Banco
    $cadastroProfessorEfetuado = $professorDao->inserir($conn, $professor);

    // VALIDAÇÃO DA INSERÇÃO DO PROFESSOR
    if($cadastroProfessorEfetuado) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Professor cadastrado com sucesso!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar professor!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_form_professor_cadastro.php');
    }
