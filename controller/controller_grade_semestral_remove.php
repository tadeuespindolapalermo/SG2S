<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeSemestralDao = new GradeSemestralDao();

    $idGradeSemestral = $_GET['idGradeSemestral'];

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    // Removendo grade do banco
    $linhas = $gradeSemestralDao->remover($conn, $idGradeSemestral);

    if ($linhas != 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo'
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade semestral removida com sucesso! Atualizando listagem...
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade_semestral.php'";
    } elseif ($linhas != 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo'
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade semestral removida com sucesso! Atualizando listagem...
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade_semestral.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade semestral!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_grades_semestrais_listagem.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade semestral! Entre em contato com o Administrador!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_grades_semestrais_listagem.php'";
    }
