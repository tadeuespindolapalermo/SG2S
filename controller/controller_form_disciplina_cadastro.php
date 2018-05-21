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

    $disciplina->setCursoIdCurso($_POST['curso_idcurso']);
    $disciplina->setNomeDisciplina($_POST['nomeDisciplina']);
    $disciplina->setCargaHoraria($_POST['cargaHoraria']);
    $disciplina->setCredito($_POST['credito']);

    // Inserção da Disciplina no Banco
    $cadastroDisciplinaEfetuado = $disciplinaDao->inserir($conn, $disciplina);

    // VALIDAÇÃO DA INSERÇÃO DA DISCIPLINA
    if($cadastroDisciplinaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo"
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_disciplina.php'";
        //header('Location: ../view/view_admin.php?pagina=view_disciplinas_listagem.php');
    } elseif ($cadastroDisciplinaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo"
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_disciplina.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_disciplinas_listagem.php');
    } elseif (!$cadastroDisciplinaEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo"
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Disciplina!!!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_disciplina_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_disciplina_cadastro.php');
    } elseif (!$cadastroDisciplinaEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo"
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Disciplina!!!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_disciplina_cadastro.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_disciplina_cadastro.php');
    }
