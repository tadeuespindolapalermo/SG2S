<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $matrizDao = new MatrizDao();
        $matriz = new Matriz();

        // Dados recebidos do formulário via POST
        $matriz->setCursoIdCurso($_POST['curso']);
        $matriz->setNomeMatriz($_POST['nomeMatriz']);
        $matriz->setCargaHoraria($_POST['cargaHoraria']);
        $matriz->setCredito($_POST['credito']);
        $matriz->setIdMatrizCurricular($_GET['idMatriz']);

        // Update do Curso no Banco
      //  $updateMatriz = $matrizDao->atualizar($conn, $matriz);
        $matriz = $matrizDao->atualizar($conn, $matriz);
        // VALIDAÇÃO DO UPDATE
        if ($matriz) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Matriz atualizada com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_matrizes_listagem.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a matriz!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_matrizes_listagem.php');
        }
    }

?>
