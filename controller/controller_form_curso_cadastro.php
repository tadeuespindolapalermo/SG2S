<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $curso = new Curso();
    $cursoDao = new CursoDao();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $curso->setNome($_POST['nome']);
    $curso->setPortaria($_POST['portaria']);
    $curso->setDuracao($_POST['duracao']);
    $curso->setGrau($_POST['grau']);
    $curso->setDataPortaria($_POST['dataPortaria']);

    // Inserção do Curso no Banco
    $cadastroCursoEfetuado = $cursoDao->inserir($conn, $curso);

    // VALIDAÇÃO DA INSERÇÃO DO CURSO
    if($cadastroCursoEfetuado) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong>Cadastro realizado com sucesso!
            </div>
        </center>';
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Curso cadastrado com sucesso!!!\");
        </script>";*/
        header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar curso!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_form_curso_cadastro.php');
    }
    echo '
    <div class="container col-md-4 form-group">
        <a href="view_admin.php?pagina=view_cursos_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
    </div>';
