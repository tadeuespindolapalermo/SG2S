<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();

    $idGrade = $_GET['idGrade'];

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    // Removendo grade do banco
    $linhas = $gradeDao->remover($conn, $idGrade);

    if ($linhas != 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo'
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade removida com sucesso! Atualizando listagem...
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade.php'";
    } elseif ($linhas != 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo'
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade removida com sucesso! Atualizando listagem...
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_grades_listagem.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade! Entre em contato com o Administrador!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_grades_listagem.php'";
    }
