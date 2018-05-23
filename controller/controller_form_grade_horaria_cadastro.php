<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeHoraria = new GradeHoraria();
    $gradeHorariaDao = new GradeHorariaDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $gradeHoraria->setSala($_POST['sala']);
    $gradeHoraria->setQuantidadeAlunos($_POST['quantidadeAlunos']);
    $gradeHoraria->setTurmas($_POST['turmas']);
    $gradeHoraria->setPeriodoCurso($_POST['periodoCurso']);
    $gradeHoraria->setDiaSemana($_POST['diaSemana']);
    $gradeHoraria->setEad($_POST['ead']);
    $gradeHoraria->setIdGradeSemestral($_POST['idGradeSemestral']);
    $gradeHoraria->setIdCursoGradeSemestral($_POST['idCursoGradeSemestral']);

    // DEBUG
    /*echo $gradeHoraria->getIdGradeSemestral();
    echo "<br>";
    echo $gradeHoraria->getIdCursoGradeSemestral();
    echo "<br>";
    echo $gradeHoraria->getSala();
    echo "<br>";
    echo $gradeHoraria->getQuantidadeAlunos();
    echo "<br>";
    echo $gradeHoraria->getTurmas();
    echo "<br>";
    echo $gradeHoraria->getPeriodoCurso();
    echo "<br>";
    echo $gradeHoraria->getDiaSemana();
    echo "<br>";
    echo $gradeHoraria->getEad();
    echo "<br>";
    exit();*/

    // Inserção da Grade Horária no Banco
    $cadastroGradeHorariaEfetuado = $gradeHorariaDao->inserir($conn, $gradeHoraria);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE HORÁRIA
    if ($cadastroGradeHorariaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade_horaria.php'";
        //header('Location: ../view/view_admin.php?pagina=view_grades_horarias_listagem.php');
    } elseif ($cadastroGradeHorariaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade_horaria.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_grades_horarias_listagem.php');
    } elseif (!$cadastroGradeHorariaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade horária!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_horaria_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_grade_horaria_cadastro.php');
    } elseif (!$cadastroGradeHorariaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade horária!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_grade_horaria_cadastro.php'";
        //header('Location: ../view/coordenador_admin.php?pagina=view_form_grade_horaria_cadastro.php');
    }
