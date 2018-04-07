<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $usuarios = new Usuarios();
        $perfil = new Perfil();

        $perfil->setDescricao($_POST['perfil']);
        if ($perfil->getDescricao() == 'Administrador') {
            $perfil->setIdPerfil(1);
        } elseif ($perfil->getDescricao('Coordenador')) {
            $perfil->setIdPerfil(2);
        }

        // Dados recebidos do formulário via POST
        $usuarios->setNome($_POST['nome']);
        $usuarios->setFone($_POST['telefone']);
        $usuarios->setUsuario($_POST['usuario']);
        $usuarios->setEmail($_POST['email']);
        $senhaNormal = $_POST['senha'];
        $usuarios->setSenha(md5($_POST['senha']));
        $usuarios->setIdUsuarios($_GET['idUsuario']);

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
            $stmtUpdateUsuario->bindValue(':nome', $usuarios->getNome());
            $stmtUpdateUsuario->bindValue(':telefone', $usuarios->getFone());
            $stmtUpdateUsuario->bindValue(':email', $usuarios->getEmail());
            $stmtUpdateUsuario->bindValue(':usuario', $usuarios->getUsuario());
            $stmtUpdateUsuario->bindValue(':senha', $usuarios->getSenha());
            $stmtUpdateUsuario->bindValue(':idUsuario', $usuarios->getIdUsuarios());
            $updateUsuario = $stmtUpdateUsuario->execute();
            // -----------------------------------------------------------

            // UPDATE DO PERFIL DO USUÁRIO
            $strSqlPerfilUsuario = "
            UPDATE usuario_perfil set
                perfil_idperfil = :idPerfil
            WHERE
                usuarios_idusuarios = :idUsuario";

            $stmtUpdatePerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
            $stmtUpdatePerfilUsuario->bindValue(':idPerfil', $perfil->getIdPerfil());
            $stmtUpdatePerfilUsuario->bindValue(':idUsuario', $usuarios->getIdUsuarios());
            $updatePerfilUsuario = $stmtUpdatePerfilUsuario->execute();
            // ------------------------------------------------------------

            // VALIDAÇÃO DO UPDATE
            if ($updateUsuario && $updatePerfilUsuario) {

                //$_SESSION['senha'] = $senhaNormal;

                echo "
                <script type=\"text/javascript\">
                    alert(\"Usuário atualizado com sucesso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
                //header('Location: ../view/view_admin.php?pagina=view_usuarios_listagem.php');
            } else {
                echo "
                <script type=\"text/javascript\">
                    alert(\"Erro ao atualizar o usuário!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
                //header('Location: ../view/view_admin.php?pagina=view_usuarios_listagem.php');
            }
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }
?>
