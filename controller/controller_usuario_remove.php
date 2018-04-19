<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuarioDao = new UsuarioDao();

    $idUsuario = $_GET['idUsuario'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    // Removendo usuário do banco
    $linhas = $usuarioDao->remover($conn, $idUsuario);

    if ($linhas != 0) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Usuário excluído com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir usuário!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
    }
