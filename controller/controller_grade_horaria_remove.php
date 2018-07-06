<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeHorariaDao = new GradeHorariaDao();

    $idGradeHoraria = $_GET['idGradeHoraria'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    // Removendo um registro de grade horária do banco
    $linhas = $gradeHorariaDao->remover($conn, $idGradeHoraria);

    if ($linhas != 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade horária excluída com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_grade_horaria.php'";
    } elseif ($linhas != 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Grade horária excluída com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_grade_horaria.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade horária!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_semestral_selecionar.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir grade horária!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_grade_semestral_selecionar.php'";
    }
