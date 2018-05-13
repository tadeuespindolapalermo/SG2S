<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $matriz = new Matriz();
    $matrizDao = new MatrizDao();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $matriz->setCursoIdCurso($_POST['curso_idcurso']);
    $matriz->setNomeMatriz($_POST['nomeMatriz']);
    $matriz->setCargaHoraria($_POST['cargaHoraria']);
    $matriz->setCredito($_POST['credito']);

    // Inserção do Curso no Banco
    $cadastroMatrizEfetuado = $matrizDao->inserir($conn, $matriz);

    // VALIDAÇÃO DA INSERÇÃO DO USUÁRIO E DO PERFIL
    if($cadastroMatrizEfetuado) {
      /*echo '
      <center>
          <div class="alert alert-success" style="width: 455px;">
              <strong>PARABÉNS!</strong>matriz cadastrada com sucesso!
          </div>
      </center>';*/
        echo"
        <script type=\"text/javascript\">
            alert(\"Matriz cadastrada com sucesso!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_matrizes_listagem.php');
    } else {
        echo"
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar matriz!!!\");
        </script>";
        header('Location: ../view/view_admin.php?pagina=view_form_matriz_cadastro.php');
    }
