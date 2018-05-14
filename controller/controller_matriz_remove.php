<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $matrizDao = new MatrizDao();

    $idMatrizCurricular = $_GET['idMatriz'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    // Removendo matriz do banco
    $linhas = $matrizDao->remover($conn, $idMatrizCurricular);

    if ($linhas != 0) {
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Matriz excluída com sucesso!!\");
        </script>*/
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Matriz excluída com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_matriz.php'";
    } else {        
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir matriz!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
    }
