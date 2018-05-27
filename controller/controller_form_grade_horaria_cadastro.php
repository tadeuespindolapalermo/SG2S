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
    $gradeHoraria->setDsSeg($_POST['dsSeg']);
    $gradeHoraria->setDsTer($_POST['dsTer']);
    $gradeHoraria->setDsQua($_POST['dsQua']);
    $gradeHoraria->setDsQui($_POST['dsQui']);
    $gradeHoraria->setDsSex($_POST['dsSex']);
    $gradeHoraria->setDsSab($_POST['dsSab']);
    $gradeHoraria->setDsEad($_POST['dsEad']);

    // TRATAMENTO DO CAMPO EAD (SALVAR NO BANCO)
    /*if($_POST['ead'] == 0) {
        $gradeHoraria->setEad("NÃO");
    } else {
        $gradeHoraria->setEad("SIM");
    }*/

    // DEBUG
    /*echo "ID GRADE SEMESTRAL: ";
    echo $gradeHoraria->getIdGradeSemestral();
    echo "<br>";
    echo "ID CURSO GRADE SEMESTRAL: ";
    echo $gradeHoraria->getIdCursoGradeSemestral();
    echo "<br>";
    echo "SALA: ";
    echo $gradeHoraria->getSala();
    echo "<br>";
    echo "QUANTIDADE DE ALUNOS: ";
    echo $gradeHoraria->getQuantidadeAlunos();
    echo "<br>";
    echo "TURMAS: ";
    echo $gradeHoraria->getTurmas();
    echo "<br>";
    echo "PERÍODO DO CURSO: ";
    echo $gradeHoraria->getPeriodoCurso();
    echo "<br>";
    echo "DIA DA SEMANA: ";
    echo $gradeHoraria->getDiaSemana();
    echo "<br>";
    echo "EAD - SIM OU NÃO: ";
    echo $gradeHoraria->getEad();
    echo "<br>";
    echo "DISCIPLINA SEGUNDA: ";
    echo $gradeHoraria->getDsSeg();
    echo "<br>";
    echo "DISCIPLINA TERÇA: ";
    echo $gradeHoraria->getDsTer();
    echo "<br>";
    echo "DISCIPLINA QUARTA: ";
    echo $gradeHoraria->getDsQua();
    echo "<br>";
    echo "DISCIPLINA QUINTA: ";
    echo $gradeHoraria->getDsQui();
    echo "<br>";
    echo "DISCIPLINA SEXTA: ";
    echo $gradeHoraria->getDsSex();
    echo "<br>";
    echo "DISCIPLINA SÁBADO: ";
    echo $gradeHoraria->getDsSab();
    echo "<br>";
    echo "DISCIPLINA EAD: ";
    echo $gradeHoraria->getDsEad();
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
        //header('Location: ../view/view_coordenador.php?pagina=view_form_grade_horaria_cadastro.php');
    }
