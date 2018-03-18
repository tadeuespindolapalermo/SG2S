<?php

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once('../db/Conexao.class.php');

        $usuarioSessao = $_SESSION['usuario'];

        $strNome = $_POST['nome'];
        $strSobrenome = $_POST['sobrenome'];
        $strEmail = $_POST['email'];
        $strSenhaNormal = $_POST['senha'];
        $strSenha = md5($_POST['senha']);

        $objConexao = new Conexao();
        $link = $objConexao->conectar();

        $strSql = "
        UPDATE usuarios set
            nome = '".$strNome."',
            sobrenome = '".$strSobrenome."',
            email = '".$strEmail."',
            senha = '".$strSenha."'
        WHERE
            usuario='{$usuarioSessao}'";

        $objConexao->atualizarUsuario($link, $strSql);

        if (mysqli_affected_rows($link) > 0) {

            $_SESSION['senha'] = $strSenhaNormal;

            echo "
            <script type=\"text/javascript\">
                alert(\"Usuário atualizado com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/index.php?usuarios.php'";
            header('Location: ../view/home.php?pagina=usuarios.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o usuário!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/index.php?usuarios.php'";
            header('Location: ../view/home.php?pagina=usuarios.php');
        }
    }
?>
