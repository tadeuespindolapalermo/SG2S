<?php

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require_once('../db/Conexao.class.php');

        $strMatricula = $_POST['matricula'];
        $strNome = $_POST['nome'];
        $strSobrenome = $_POST['sobrenome'];
        $strTelefone = $_POST['telefone'];
        $strUsuario = $_POST['usuario'];
        $strEmail = $_POST['email'];

        $objConexao = new Conexao();
        $link = $objConexao->conectar();

        $strSql = "
        UPDATE usuarios set
            matricula = '".$strMatricula."',
            nome = '".$strNome."',
            sobrenome = '".$strSobrenome."',
            telefone = '".$strTelefone."',
            usuario = '".$strUsuario."',
            email = '".$strEmail."'
        WHERE
            id = ".$_GET['idUsuario'];

        $objConexao->atualizarUsuario($link, $strSql);

        if (mysqli_affected_rows($link) > 0) {

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
