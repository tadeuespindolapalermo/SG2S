<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $gradeDao = new GradeDao();
        $grade = new Grade();

        // Dados recebidos do formulário via POST
        $grade->setAnoLetivo($_POST['anoLetivo']);
        $grade->setSemestre($_POST['semestre']);
        $grade->setPeriodo($_POST['periodo']);
        $grade->setSala($_POST['sala']);
        $grade->setQuantidadeAlunos($_POST['quantidadeAlunos']);
        $grade->setTurmas($_POST['turmas']);
        $grade->setCursoIdCurso($_POST['curso']);
        $grade->setIdGradeSemestral($_GET['idGrade']);

        // Verificação do Horário
        if($grade->getPeriodo() === 'Matutino') {
            $grade->setHorario('08:00 às 12:00');
        } elseif ($grade->getPeriodo() === 'Vespertino') {
            $grade->setHorario('13:00 às 18:00');
        } elseif ($grade->getPeriodo() === 'Noturno') {
            $grade->setHorario('19:15 às 22:00');
        }

        // Update da Grade no Banco
        $updateGrade = $gradeDao->atualizar($conn, $grade);

        // VALIDAÇÃO DO UPDATE
        if ($updateGrade && $_SESSION['perfil_idperfil'] == 1) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 600px;">
                    Grade atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
        } elseif ($updateGrade && $_SESSION['perfil_idperfil'] == 2) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 600px;">
                    Grade atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_grades_listagem.php');
        } elseif (!$updateGrade && $_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a grade!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_grades_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
        } elseif (!$updateGrade && $_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a grade!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_grades_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_grades_listagem.php');
        }

    }
