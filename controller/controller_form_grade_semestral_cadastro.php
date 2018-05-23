<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeSemestral = new GradeSemestral();
    $gradeSemestralDao = new GradeSemestralDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $gradeSemestral->setAnoLetivo($_POST['anoLetivo']);
    $gradeSemestral->setSemestreLetivo($_POST['semestreLetivo']);
    $gradeSemestral->setTurno($_POST['turno']);
    $gradeSemestral->setCursoIdCurso($_POST['curso_idcurso']);

    // Verificação do Horário
    if($gradeSemestral->getTurno() === 'Matutino') {
        $gradeSemestral->setHorario('08:00 às 12:00');
    } elseif ($gradeSemestral->getTurno() === 'Vespertino') {
        $gradeSemestral->setHorario('13:00 às 18:00');
    } elseif ($gradeSemestral->getTurno() === 'Noturno') {
        $gradeSemestral->setHorario('19:15 às 22:00');
    }

    // Inserção da Grade no Banco
    $cadastroGradeSemestralEfetuado = $gradeSemestralDao->inserir($conn, $gradeSemestral);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE
    if ($cadastroGradeSemestralEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade_semestral.php'";
        //header('Location: ../view/view_admin.php?pagina=view_grades_semestrais_listagem.php');
    } elseif ($cadastroGradeSemestralEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade_semestral.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_grades_semestrais_listagem.php');
    } elseif (!$cadastroGradeSemestralEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade semestral!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_semestral_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_grade_semestral_cadastro.php');
    } elseif (!$cadastroGradeSemestralEfetuadoGradeEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade semestral!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_grade_semestral_cadastro.php'";
        //header('Location: ../view/coordenador_admin.php?pagina=view_form_grade_semestral_cadastro.php');
    }
