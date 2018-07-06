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
    $disciplina->setIdProfessorDisciplina($_POST['idProfessor']);

    /*$selectCursoDisciplina = $disciplinaDao->buscarPorId($conn, $disciplina->getIdDisciplina());
    $linhaCursoDisciplina = $selectCursoDisciplina->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaCursoDisciplina as $dados)
        $disciplina->setCursoIdCurso($dados['curso_idcurso']);*/

    // Inserção da Grade Horária no Banco
    $associacaoProfessorEfetuada = $disciplinaDao->associarProfessor($conn, $disciplina);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE HORÁRIA
    if ($associacaoProfessorEfetuada && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Associação realizada com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_professor.php'";
        //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
    } elseif ($associacaoProfessorEfetuada && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Associação realizada com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_professor.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_professores_listagem.php');
    } elseif (!$associacaoProfessorEfetuada && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao associar Professor à Disciplina!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_professor_associar.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_professor_associar.php');
    } elseif (!$associacaoProfessorEfetuada && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao associar Professor à Disciplina!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_professor_associar.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_professor_associar.php');
    }
