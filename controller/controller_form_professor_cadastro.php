<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professor = new Professor();
    $professorDao = new ProfessorDao();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    $professor->setNome($_POST['nome']);
    $professor->setCPF($_POST['cpf']);
    $professor->setRG($_POST['rg']);
    $professor->setEmail($_POST['email']);
    $professor->setFone($_POST['telefone']);
    $professor->setExclusao(1);

    // Inserção do Professor no Banco
    $cadastroProfessorEfetuado = $professorDao->inserir($conn, $professor);

    // VALIDAÇÃO DA INSERÇÃO DO PROFESSOR
    if($cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_professor.php'";
        //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
    } elseif ($cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                <strong>PARABÉNS!</strong> Cadastro realizado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_professor.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_professores_listagem.php');
    } elseif (!$cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Professor(a)!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_professor_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_professor_cadastro.php');
    } elseif (!$cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Professor(a)!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_professor_cadastro.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_professor_cadastro.php');
    }
