<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $cursoDao = new CursoDao();

    $idCurso = $_GET['idCurso'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    // Removendo curso do banco
    $linhas = $cursoDao->remover($conn, $idCurso);

    if ($linhas != 0) {
      echo '<center>
      <div class="alert alert-success" style="width: 455px;">
          Curso removido com sucesso!
      </div>
  </center>';

        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";

    } else {
      echo '<center>
      <div class="alert alert-danger" style="width: 600px;">
          Erro ao excluir curso! Este curso está vinculado a uma ou mais matriz!
      </div>
  </center>';
        echo "

        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
    }
