<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    /*if ($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $professorDao = new ProfessorDao();
        $professor = new Professor();

        if ($_SESSION['perfil_idperfil'] == 1) {
    		$url = 'view_admin.php';
    	} elseif ($_SESSION['perfil_idperfil'] == 2) {
    		$url = 'view_coordenador.php';
    	}

        // Dados recebidos do formulário via POST
        $professor->setNome($_POST['nome']);
        $professor->setCPF($_POST['cpf']);
        $professor->setRG($_POST['rg']);
        $professor->setEmail($_POST['email']);
        $professor->setFone($_POST['telefone']);
        $professor->setIdProfessor($_GET['idProfessor']);

        $validacaoCPF = $professor->validarCPF($professor->getCPF());

        if($validacaoCPF) {
            // Update do Professor no Banco
            $updateProfessor = $professorDao->atualizar($conn, $professor);
        } else {
            echo '
            <center>
                <div class="alert alert-danger" style="width: 455px;">
                    <strong>CPF INVÁLIDO! IMPOSSÍVEL ATUALIZAR!</strong>
                </div>
            </center>';
            echo '
            <a href="'; echo $url; echo '?pagina=view_form_professor_update.php&idProfessor=';echo $professor->getIdProfessor(); echo '"><button type="button" style="width: 455px; margin-left: 318px;" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>';
            exit();
        }

        // VALIDAÇÃO DO UPDATE
        if ($validacaoCPF && $updateProfessor && $_SESSION['perfil_idperfil'] == 1) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Professor '; echo $professor->getNome(); echo ' atualizado com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_professor.php'";
            //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
        } elseif ($validacaoCPF && $updateProfessor && $_SESSION['perfil_idperfil'] == 2) {
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Professor '; echo $professor->getNome(); echo ' atualizado com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_professor.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_professores_listagem.php');
        } elseif (!$validacaoCPF || !$updateProfessor && $_SESSION['perfil_idperfil'] == 1) {
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
                alert(\"Erro ao atualizar Professor(a)!\");
            </script>";

            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_professores_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
        } elseif (!$validacaoCPF || !$updateProfessor && $_SESSION['perfil_idperfil'] == 2) {
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
                alert(\"Erro ao atualizar Professor(a)!\");
            </script>";

            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_professores_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_professores_listagem.php');
        }

    }
