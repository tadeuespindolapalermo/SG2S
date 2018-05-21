<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $grade = new Grade();
    $gradeDao = new GradeDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $grade->setAnoLetivo($_POST['anoLetivo']);
    $grade->setSemestreLetivo($_POST['semestreLetivo']);
    $grade->setTurno($_POST['turno']);
    $grade->setCursoIdCurso($_POST['curso_idcurso']);

    // Verificação do Horário
    if($grade->getTurno() === 'Matutino') {
        $grade->setHorario('08:00 às 12:00');
    } elseif ($grade->getTurno() === 'Vespertino') {
        $grade->setHorario('13:00 às 18:00');
    } elseif ($grade->getTurno() === 'Noturno') {
        $grade->setHorario('19:15 às 22:00');
    }

    // Inserção da Grade no Banco
    $cadastroGradeEfetuado = $gradeDao->inserir($conn, $grade);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE
    if ($cadastroGradeEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade.php'";
        //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
    } elseif ($cadastroGradeEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_grades_listagem.php');
    } elseif (!$cadastroGradeEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_grade_cadastro.php');
    } elseif (!$cadastroGradeEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_grade_cadastro.php'";
        //header('Location: ../view/coordenador_admin.php?pagina=view_form_grade_cadastro.php');
    }
