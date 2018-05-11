<?php
    session_start();
    ob_start();
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
        echo "
        <script type=\"text/javascript\">
            alert(\"Matriz cadastrada com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_matrizes_listagem.php'";
        //header('Location: ../view/view_admin.php?pagina=view_matrizes_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Matriz!!!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_matriz_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_matriz_cadastro.php');
    }
