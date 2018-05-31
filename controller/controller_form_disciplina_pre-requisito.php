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
    //$disciplina->setCursoIdCurso($_POST['cursoDisciplina']);

    // Estabelecer disciplina pré-requisito
    $definirDisciplinaPreRequisito = $disciplinaDao->definirDisciplinaPreRequisito($conn, $disciplina);

    // VALIDAÇÃO DA INSERÇÃO DA GRADE HORÁRIA
    if ($definirDisciplinaPreRequisito && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Disciplina pré-requisito definida com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_disciplina.php'";
        //header('Location: ../view/view_admin.php?pagina=view_disciplinas_listagem.php');
    } elseif ($definirDisciplinaPreRequisito && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Disciplina pré-requisito definida com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_disciplina.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_disciplinas_listagem.php');
    } elseif (!$definirDisciplinaPreRequisito && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao definir disciplina pré-requisito!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_disciplina_pre-requisito.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_disciplina_pre-requisito.php');
    } elseif (!$definirDisciplinaPreRequisito && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao definir disciplina pré requisito!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_disciplina_pre-requisito.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_disciplina_pre-requisito.php');
    }
