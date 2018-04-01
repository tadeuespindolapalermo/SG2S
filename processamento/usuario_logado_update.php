<?php

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once('../db/Conexao.class.php');

        $idUsuarioSessao = $_SESSION['idusuarios'];

        $strNome = $_POST['nome'];
        $strTelefone = $_POST['telefone'];
        $strEmail = $_POST['email'];
        $strUsuario = $_POST['usuario'];
        $strSenhaNormal = $_POST['senha'];
        $strSenha = md5($_POST['senha']);

        $objConexao = new Conexao();
        $link = $objConexao->conectar();

        $strSql = "
        UPDATE usuarios set
            nome = '".$strNome."',
            fone = '".$strTelefone."',
            usuario = '".$strUsuario."',
            email = '".$strEmail."',
            senha = '".$strSenha."'
        WHERE
            idusuarios='{$idUsuarioSessao}'";

        $objConexao->atualizarUsuario($link, $strSql);

        if (mysqli_affected_rows($link) > 0) {

            $_SESSION['senha'] = $strSenhaNormal;
            $_SESSION['nome'] = $strNome;
            $_SESSION['email'] = $strEmail;

            if($_SESSION['perfil_idperfil'] == 2) {
                echo "
                <script type=\"text/javascript\">
                    alert(\"Usuário atualizado com sucesso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/coordenador.php?pagina=home.php'";
                header('Location: ../view/coordenador.php?pagina=home.php');
            } elseif($_SESSION['perfil_idperfil'] == 1) {
                echo "
                <script type=\"text/javascript\">
                    alert(\"Usuário atualizado com sucesso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/admin.php?pagina=home.php'";
                header('Location: ../view/admin.php?pagina=home.php');
            }
        } else {
            $retorno_get = '';
            if($_SESSION['perfil_idperfil'] == 1) {

                $retorno_get.= "erro_update=1&";

                header('Location: ../view/admin.php?pagina=view_usuario_logado_update.php&' . $retorno_get);
                die();

            } elseif ($_SESSION['perfil_idperfil'] == 2) {

                $retorno_get.= "erro_update=1&";

                header('Location: ../view/coordenador.php?pagina=view_usuario_logado_update.php&' . $retorno_get);
                die();
            }
        }
    }
?>
