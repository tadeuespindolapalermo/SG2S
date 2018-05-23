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

        $gradeSemestralDao = new GradeSemestralDao();
        $gradeSemestral = new GradeSemestral();

        // Dados recebidos do formulário via POST
        $gradeSemestral->setAnoLetivo($_POST['anoLetivo']);
        $gradeSemestral->setSemestreLetivo($_POST['semestreLetivo']);
        $gradeSemestral->setTurno($_POST['turno']);
        $gradeSemestral->setCursoIdCurso($_POST['curso']);
        $gradeSemestral->setIdGradeSemestral($_GET['idGradeSemestral']);

        // Verificação do Horário
        if($gradeSemestral->getTurno() === 'Matutino') {
            $gradeSemestral->setHorario('08:00 às 12:00');
        } elseif ($gradeSemestral->getTurno() === 'Vespertino') {
            $gradeSemestral->setHorario('13:00 às 18:00');
        } elseif ($gradeSemestral->getTurno() === 'Noturno') {
            $gradeSemestral->setHorario('19:15 às 22:00');
        }

        // Update da Grade no Banco
        $updateGradeSemestral = $gradeSemestralDao->atualizar($conn, $gradeSemestral);

        // VALIDAÇÃO DO UPDATE
        if ($updateGradeSemestral && $_SESSION['perfil_idperfil'] == 1) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 600px;">
                    Grade semestral atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade_semestral.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_semestrais_listagem.php');
        } elseif ($updateGradeSemestral && $_SESSION['perfil_idperfil'] == 2) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 600px;">
                    Grade semestral atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade_semestral.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_grades_semestrais_listagem.php');
        } elseif (!$updateGradeSemestral && $_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a grade semestral!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_grades_semestrais_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_grades_semestrais_listagem.php');
        } elseif (!$updateGradeSemestral && $_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a grade semestral!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_grades_semestrais_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_grades_semestrais_listagem.php');
        }

    }
