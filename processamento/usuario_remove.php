<?php

    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/sair.php');
    }

    require_once('../db/Conexao.class.php');

    $usuarioSessao = $_SESSION['usuario'];

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $strSql = "DELETE FROM usuarios WHERE idusuarios=".$_GET['idUsuario'];

    $rs = $objConexao->executarConsulta($link, $strSql);

    $linhas = mysqli_affected_rows($link);

    if ($linhas != 0) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Usuário excluído com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir usuário!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
    }
