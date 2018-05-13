<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professorDao = new ProfessorDao();
    $professor = new Professor();

    $idProfessor = $_GET['idProfessor'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $professor->setExclusao(1);
    $professor->setIdProfessor($idProfessor);

    // Update do Professor no Banco
    $updateProfessor = $professorDao->atualizarExclusao($conn, $professor);

    // VALIDAÇÃO DO UPDATE
    if ($updateProfessor) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Professor recuperado com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_professores_lixeira_listagem.php'";
        //header('Location: ../view/view_admin.php?pagina=view_professores_lixeira_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao recuperar o professor!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_professores_lixeira_listagem.php'";
        //header('Location: ../view/view_admin.php?pagina=view_professores_listagem.php');
    }


?>
