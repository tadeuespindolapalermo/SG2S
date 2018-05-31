<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $disciplina = new Disciplina();
    $disciplinaDao = new DisciplinaDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $disciplina->setIdDisciplina($_POST['comboDisciplinas']);
    $disciplina->setCursoIdCurso($_POST['idCurso']);

    /*$selectCursoDisciplina = $disciplinaDao->buscarPorId($conn, $disciplina->getIdDisciplina());
    $linhaCursoDisciplina = $selectCursoDisciplina->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaCursoDisciplina as $dados)
        $disciplina->setCursoIdCurso($dados['curso_idcurso']);*/

    // Associação de curso à disciplina
    $associacaoCursoEfetuada = $disciplinaDao->associarCurso($conn, $disciplina);

    // VALIDAÇÃO DA INSERÇÃO DO CURSO
    if ($associacaoCursoEfetuada && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Associação realizada com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_curso.php'";
        //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
    } elseif ($associacaoCursoEfetuada && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Associação realizada com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_curso.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_cursos_listagem.php');
    } elseif (!$associacaoCursoEfetuada && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao associar Curso à Disciplina!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_curso_associar.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_curso_associar.php');
    } elseif (!$associacaoCursoEfetuada && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao associar Curso à Disciplina!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_curso_associar.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_curso_associar.php');
    }
