<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = new Usuarios();
        $perfil = new Perfil();
        $usuarioDao = new UsuarioDao();

        $perfil->setDescricao($_POST['perfil']);
        if ($perfil->getDescricao() == 'Administrador') {
            $perfil->setIdPerfil(1);
        } elseif ($perfil->getDescricao('Coordenador')) {
            $perfil->setIdPerfil(2);
        }

        // Dados recebidos do formulário via POST
        $usuario->setNome($_POST['nome']);
        $usuario->setFone($_POST['telefone']);
        $usuario->setUsuario($_POST['usuario']);
        $usuario->setEmail($_POST['email']);
        $senhaNormal = $_POST['senha'];
        $usuario->setSenha(md5($_POST['senha']));
        $usuario->setIdUsuarios($_GET['idUsuario']);

        // Inserção do Usuário no Banco
        $updateUsuario = $usuarioDao->atualizar($conn, $usuario);
        $updatePerfilUsuario = $usuarioDao->atualizarPerfil($conn, $usuario, $perfil);

        // VALIDAÇÃO DO UPDATE
        if ($updateUsuario && $updatePerfilUsuario) {
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
    }
?>
