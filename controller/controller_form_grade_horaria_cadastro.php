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
    $gradeHoraria->setDsEad1($_POST['dsEad1']);
    $gradeHoraria->setDsEad2($_POST['dsEad2']);

    $selectProfessorDisciplinaSeg = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsSeg());
    $linhaProfessorDisciplinaSeg = $selectProfessorDisciplinaSeg->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaSeg as $dados) {
        $gradeHoraria->setDsSegProf($dados['nome']);
    }

    $selectProfessorDisciplinaTer = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsTer());
    $linhaProfessorDisciplinaTer = $selectProfessorDisciplinaTer->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaTer as $dados) {
        $gradeHoraria->setDsTerProf($dados['nome']);
    }

    $selectProfessorDisciplinaQua = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsQua());
    $linhaProfessorDisciplinaQua = $selectProfessorDisciplinaQua->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaQua as $dados) {
        $gradeHoraria->setDsQuaProf($dados['nome']);
    }

    $selectProfessorDisciplinaQui = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsQui());
    $linhaProfessorDisciplinaQui = $selectProfessorDisciplinaQui->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaQui as $dados) {
        $gradeHoraria->setDsQuiProf($dados['nome']);
    }

    $selectProfessorDisciplinaSex = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsSex());
    $linhaProfessorDisciplinaSex = $selectProfessorDisciplinaSex->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaSex as $dados) {
        $gradeHoraria->setDsSexProf($dados['nome']);
    }

    $selectProfessorDisciplinaSab = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsSab());
    $linhaProfessorDisciplinaSab = $selectProfessorDisciplinaSab->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaSab as $dados) {
        $gradeHoraria->setDsSabProf($dados['nome']);
    }

    $selectProfessorDisciplinaEad1 = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsEad1());
    $linhaProfessorDisciplinaEad1 = $selectProfessorDisciplinaEad1->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaEad1 as $dados) {
        $gradeHoraria->setDsEad1Prof($dados['nome']);
    }

    $selectProfessorDisciplinaEad2 = $gradeHorariaDao->listarProfessorDisciplina($conn, $gradeHoraria->getDsEad2());
    $linhaProfessorDisciplinaEad2 = $selectProfessorDisciplinaEad2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaProfessorDisciplinaEad2 as $dados) {
        $gradeHoraria->setDsEad2Prof($dados['nome']);
    }

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
