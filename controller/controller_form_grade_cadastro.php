<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $grade = new Grade();
    $gradeDao = new GradeDao();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $grade->setAnoLetivo($_POST['anoLetivo']);
    $grade->setSemestre($_POST['semestre']);
    $grade->setPeriodo($_POST['periodo']);
    $grade->setHorario($_POST['horario']);
    $grade->setSala($_POST['sala']);
    $grade->setQuantidadeAlunos($_POST['quantidadeAlunos']);
    $grade->setTurmas($_POST['turmas']);
    $grade->setCursoIdCurso($_POST['curso_idcurso']);

    // Inserção da Grade no Banco
    $cadastroGradeEfetuado = $gradeDao->inserir($conn, $grade);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE
    if($cadastroGradeEfetuado) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Grade cadastrada com sucesso!!!\");
        </script>"
       header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');

    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_form_grade_cadastro.php');
    }
