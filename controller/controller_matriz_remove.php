<?php
    session_start();

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

    // Removendo curso do banco
    $linhas = $matrizDao->remover($conn, $idMatrizCurricular);

    if ($linhas != 0) {
      echo '
      <center>
          <div class="alert alert-success" style="width: 455px;">
              <p>matriz excluida com sucesso!</p>
          </div>
      </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir matriz!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
    }
