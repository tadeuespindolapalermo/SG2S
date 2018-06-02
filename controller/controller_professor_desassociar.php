<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $disciplinaDao = new DisciplinaDao();

    $idDisciplina = $_GET['idDisciplina'];
    $idProfessor = $_GET['idProfessor'];

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    // Desassociando professor de disciplina
    $linhas = $disciplinaDao->desassociarDisciplina($conn, $idDisciplina, $idProfessor);

    if ($linhas != 0 && $_SESSION['perfil_idperfil'] == 1) {
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Professor desassociado com sucesso!\");
        </script>*/
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Professor desassociado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_disciplina.php'";
    } elseif ($linhas != 0 && $_SESSION['perfil_idperfil'] == 2) {
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Professor desassociado com sucesso!\");
        </script>*/
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Professor desassociado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_disciplina.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao desassociar professor\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_disciplinas_listagem.php'";
    } elseif ($linhas == 0 && $_SESSION['perfil_idperfil'] == 2) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao desassociar professor!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_coordenador.php?pagina=view_disciplinas_listagem.php'";
    }
