<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $gradeDao = new GradeDao();
        $grade = new Grade();

        // Dados recebidos do formulário via POST
        $grade->setAnoLetivo($_POST['anoLetivo']);
        $grade->setSemestre($_POST['semestre']);
        $grade->setPeriodo($_POST['periodo']);
        $grade->setHorario($_POST['horario']);
        $grade->setSala($_POST['sala']);
        $grade->setQuantidadeAlunos($_POST['quantidadeAlunos']);
        $grade->setTurmas($_POST['turmas']);
        $grade->setCursoIdCurso($_POST['curso']);
        $grade->setIdGradeSemestral($_GET['idGrade']);

        // Update da Grade no Banco
        $updateGrade = $gradeDao->atualizar($conn, $grade);

        // VALIDAÇÃO DO UPDATE
        if ($updateGrade) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Grade atualizada com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_grades_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a grade!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_grades_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
        }
    }
