<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $strPerfil = $_POST['perfil'];
        if ($strPerfil == 'Administrador') {
            $strPerfil = 1;
        } elseif ($strPerfil == 'Coordenador') {
            $strPerfil = 2;
        }

        // Dados recebidos do formulário via POST
        $strNome = $_POST['nome'];
        $strTelefone = $_POST['telefone'];
        $strUsuario = $_POST['usuario'];
        $strEmail = $_POST['email'];
        $strSenhaNormal = $_POST['senha'];
        $strSenha = md5($_POST['senha']);
        $strIdUsuario = $_GET['idUsuario'];

        try {
            // UPDATE DO USUÁRIO
            $strSqlUsuario = "
            UPDATE usuarios set
                nome = :nome,
                fone = :telefone,
                usuario = :usuario,
                email = :email,
                senha = :senha
            WHERE
                idusuarios = :idUsuario";

            $stmtUpdateUsuario = $conn->prepare($strSqlUsuario);
            $stmtUpdateUsuario->bindParam(':nome', $strNome);
            $stmtUpdateUsuario->bindParam(':telefone', $strTelefone);
            $stmtUpdateUsuario->bindParam(':email', $strEmail);
            $stmtUpdateUsuario->bindParam(':usuario', $strUsuario);
            $stmtUpdateUsuario->bindParam(':senha', $strSenha);
            $stmtUpdateUsuario->bindParam(':idUsuario', $strIdUsuario);
            $updadeUsuario = $stmtUpdateUsuario->execute();
            // -----------------------------------------------------------

            // UPDATE DO PERFIL DO USUÁRIO
            $strSqlPerfilUsuario = "
            UPDATE usuario_perfil set
                perfil_idperfil = :idPerfil
            WHERE
                usuarios_idusuarios = :idUsuario";

            $stmtUpdatePerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
            $stmtUpdatePerfilUsuario->bindParam(':idPerfil', $strPerfil);
            $stmtUpdatePerfilUsuario->bindParam(':idUsuario', $strIdUsuario);
            $updadePerfilUsuario = $stmtUpdatePerfilUsuario->execute();
            // ------------------------------------------------------------

            // VALIDAÇÃO DO UPDATE
            if ($updadeUsuario && $updadePerfilUsuario) {

                $_SESSION['senha'] = $strSenhaNormal;

                echo "
                <script type=\"text/javascript\">
                    alert(\"Usuário atualizado com sucesso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
                //header('Location: ../view/admin.php?pagina=usuarios_listagem.php');
            } else {
                echo "
                <script type=\"text/javascript\">
                    alert(\"Erro ao atualizar o usuário!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
                //header('Location: ../view/admin.php?pagina=usuarios_listagem.php');
            }
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }
?>
