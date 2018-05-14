<?php
    session_start();
    ob_start();
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

    // Removendo professor definitivamente do banco (exclusão física)
    $linhas = $professorDao->removerDefinitivo($conn, $idProfessor);

    if ($linhas != 0) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Professor excluído definitivamente com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_professor_lixeira.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir professor!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_professores_lixeira_listagem.php'";
    }
