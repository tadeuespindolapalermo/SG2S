<?php
    session_start();
    ob_start();
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
    $grade->setSala($_POST['sala']);
    $grade->setQuantidadeAlunos($_POST['quantidadeAlunos']);
    $grade->setTurmas($_POST['turmas']);
    $grade->setCursoIdCurso($_POST['curso_idcurso']);

    // Verificação do Horário
    if($grade->getPeriodo() === 'Matutino') {
        $grade->setHorario('08:00 às 12:00');
    } elseif ($grade->getPeriodo() === 'Vespertino') {
        $grade->setHorario('13:00 às 18:00');
    } elseif ($grade->getPeriodo() === 'Noturno') {
        $grade->setHorario('19:15 às 22:00');
    }

    // Inserção da Grade no Banco
    $cadastroGradeEfetuado = $gradeDao->inserir($conn, $grade);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE
    if ($cadastroGradeEfetuado) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_grade.php'";
        //header('Location: ../view/view_admin.php?pagina=view_grades_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar grade!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_grade_cadastro.php');
    }
