<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professorDao = new ProfessorDao();

    $idProfessor = $_GET['idProfessor'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    // Removendo curso do banco
    $linhas = $professorDao->removerDefinitivo($conn, $idProfessor);

    if ($linhas != 0) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Professor eliminado com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_professores_excluidos_listagem.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao eliminar professor!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_professores_excluidos_listagem.php'";
    }
