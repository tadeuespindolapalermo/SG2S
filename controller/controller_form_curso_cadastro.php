<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $curso = new Curso();
    $cursoDao = new CursoDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    if ($_SESSION['perfil_idperfil'] == 1) {
        $url = 'view_admin.php';
    } elseif ($_SESSION['perfil_idperfil'] == 2) {
        $url = 'view_coordenador.php';
    }

    $curso->setNome($_POST['nome']);
    $curso->setPortaria($_POST['portaria']);
    $curso->setDuracao($_POST['duracao']);
    $curso->setGrau($_POST['grau']);
    $curso->setDataPortaria($_POST['dataPortaria']);
    $curso->setVersaoMatriz($_POST['versaoMatriz']);

    // Inserção do Curso no Banco
    $cadastroCursoEfetuado = $cursoDao->inserir($conn, $curso);

    // VALIDAÇÃO DA INSERÇÃO DO CURSO
    if($cadastroCursoEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_curso.php'";
        //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
    } elseif ($cadastroCursoEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_curso.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_cursos_listagem.php');
    } elseif (!$cadastroCursoEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar curso!!!\");
        </script>";
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_curso_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_curso_cadastro.php');
    } elseif (!$cadastroCursoEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar curso!!!\");
        </script>";
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_curso_cadastro.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_curso_cadastro.php');
    }
    /*echo '
    <div class="container col-md-4 form-group">
        <a href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
    </div>';*/
