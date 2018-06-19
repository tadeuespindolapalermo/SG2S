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

    if ($_SESSION['perfil_idperfil'] == 1) {
		$url = 'view_admin.php';
	} elseif ($_SESSION['perfil_idperfil'] == 2) {
		$url = 'view_coordenador.php';
	}

    $professor->setNome($_POST['nome']);
    $professor->setCPF($_POST['cpf']);
    $professor->setRG($_POST['rg']);
    $professor->setEmail($_POST['email']);
    $professor->setFone($_POST['telefone']);
    $professor->setExclusao(1);

    $validacaoCPF = $professor->validarCPF($professor->getCPF());

    if($validacaoCPF) {
        // Inserção do Professor no Banco
        $cadastroProfessorEfetuado = $professorDao->inserir($conn, $professor);
    } else {
        echo '
        <center>
            <div class="alert alert-danger" style="width: 455px;">
                <strong>CPF INVÁLIDO! IMPOSSÍVEL CADASTRAR!</strong>
            </div>
        </center>';
        echo '
        <a href="'; echo $url; echo '?pagina=view_form_professor_cadastro.php"><button type="button" style="width: 455px; margin-left: 318px;" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>';
        exit();
    }



    // VALIDAÇÃO DA INSERÇÃO DO PROFESSOR
    if($validacaoCPF && $cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 1) {
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
    } elseif ($validacaoCPF && $cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 2) {
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
    } elseif (!$validacaoCPF || !$cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 1) {
        if(!$validacaoCPF) {
            echo '
            <center>
                <div class="alert alert-danger" style="width: 455px;">
                    <strong>CPF INVÁLIDO</strong>
                </div>
            </center>';
            exit();
        }
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Professor(a)!\");
        </script>";

        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_professor_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_professor_cadastro.php');
    } elseif (!$validacaoCPF || !$cadastroProfessorEfetuado && $_SESSION['perfil_idperfil'] == 2) {
        if(!$validacaoCPF) {
            echo '
            <center>
                <div class="alert alert-danger" style="width: 455px;">
                    <strong>CPF INVÁLIDO</strong>
                </div>
            </center>';
            exit();
        }
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Professor(a)!\");
        </script>";

        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_professor_cadastro.php'";
        //header('Location: ../view/view_coordenador.php?pagina=view_form_professor_cadastro.php');
    }
?>
