<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeGerada = new GradeGerada();
    $gradeGeradaDao = new GradeGeradaDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $gradeGerada->setDisciplinaSegunda($_POST['disciplinaSegunda']);
    $gradeGerada->setDisciplinaTerca($_POST['disciplinaTerca']);
    $gradeGerada->setDisciplinaQuarta($_POST['disciplinaQuarta']);
    $gradeGerada->setDisciplinaQuinta($_POST['disciplinaQuinta']);
    $gradeGerada->setDisciplinaSexta($_POST['disciplinaSexta']);
    $gradeGerada->setDisciplinaSabado($_POST['disciplinaSabado']);
    $gradeGerada->setDisciplinaEad($_POST['disciplinaEad']);
    $gradeGerada->setSalaSegunda($_POST['salaSegunda']);
    $gradeGerada->setSalaTerca($_POST['salaTerca']);
    $gradeGerada->setSalaQuarta($_POST['salaQuarta']);
    $gradeGerada->setSalaQuinta($_POST['salaQuinta']);
    $gradeGerada->setSalaSexta($_POST['salaSexta']);
    $gradeGerada->setSalaSabado($_POST['salaSabado']);
    $gradeGerada->setSalaEad($_POST['salaEad']);

    // Inserção da Grade Gerada no Banco
    $cadastroGradeGeradaEfetuado = $gradeGeradaDao->inserir($conn, $gradeGerada);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE GERADA
    if($cadastroGradeGeradaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Grade cadastrada com sucesso!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_grade_gerada.php');
    } elseif ($cadastroGradeGeradaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Grade cadastrada com sucesso!!!\");
        </script>";
        header('Location: ../view/view_coordenador.php?pagina=view_grade_gerada.php');
    } elseif (!$cadastroGradeGeradaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_form_grade_gerar.php');
    } elseif (!$cadastroGradeGeradaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!!!\");
        </script>";
        header('Location: ../view/view_coordenador.php?pagina=view_form_grade_gerar.php');
    }
