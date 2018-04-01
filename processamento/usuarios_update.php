<?php

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once('../db/Conexao.class.php');

        $strPerfil = $_POST['perfil'];

        if ($strPerfil == 'Administrador') {
            $strPerfil = 1;
        } elseif ($strPerfil == 'Coordenador') {
            $strPerfil = 2;
        }

        $strNome = $_POST['nome'];
        $strTelefone = $_POST['telefone'];
        $strUsuario = $_POST['usuario'];
        $strEmail = $_POST['email'];
        $strSenhaNormal = $_POST['senha'];
        $strSenha = md5($_POST['senha']);

        $objConexao = new Conexao();
        $link1 = $objConexao->conectar();
        $link2 = $objConexao->conectar();

        $strSqlUsuario = "
        UPDATE usuarios set
            nome = '".$strNome."',
            fone = '".$strTelefone."',
            usuario = '".$strUsuario."',
            email = '".$strEmail."',
            senha = '".$strSenha."'
        WHERE
            idusuarios = ".$_GET['idUsuario'];

        $strSqlPerfilUsuario = "
        UPDATE usuario_perfil set
            perfil_idperfil = '".$strPerfil."'
        WHERE
            usuarios_idusuarios = ".$_GET['idUsuario'];

        $objConexao->atualizarUsuario($link1, $strSqlPerfilUsuario);
        $objConexao->atualizarUsuario($link2, $strSqlUsuario);

        if ((mysqli_affected_rows($link1)) || (mysqli_affected_rows($link2)) > 0) {

            $_SESSION['senha'] = $strSenhaNormal;

            echo "
            <script type=\"text/javascript\">
                alert(\"Usuário atualizado com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
            header('Location: ../view/admin.php?pagina=usuarios_listagem.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o usuário! Modifique algum dado no formulário!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
            header('Location: ../view/admin.php?pagina=usuarios_listagem.php');
        }
    }
?>
