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

        // Dados recebidos do formulário via POST
        $professor->setNome($_POST['nome']);
        $professor->setCPF($_POST['cpf']);
        $professor->setRG($_POST['rg']);
        $professor->setEmail($_POST['email']);
        $professor->setFone($_POST['telefone']);
        $professor->setIdProfessor($_GET['idProfessor']);

        // Update do Professor no Banco
        $updateProfessor = $professorDao->atualizar($conn, $professor);

        // VALIDAÇÃO DO UPDATE
        if ($updateProfessor && $_SESSION['perfil_idperfil'] == 1) {
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
        } elseif ($updateProfessor && $_SESSION['perfil_idperfil'] == 2) {
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
        } elseif (!$updateProfessor && $_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o professor!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_professores_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
        } elseif (!$updateProfessor && $_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o professor!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_professores_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_professores_listagem.php');
        }

    }
