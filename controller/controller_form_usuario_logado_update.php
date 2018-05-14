<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = new Usuarios();
        $perfil = new Perfil();
        $usuarioDao = new UsuarioDao();

        $idUsuarioSessao = $_SESSION['idusuarios'];

        // Dados recebidos do formulário via POST
        $usuario->setNome($_POST['nome']);
        $usuario->setFone($_POST['telefone']);
        $usuario->setEmail($_POST['email']);
        $usuario->setUsuario($_POST['usuario']);
        $senhaNormal = $_POST['senha'];
        $usuario->setSenha(md5($_POST['senha']));

        $updateUsuarioLogado =  $usuarioDao->atualizarUsuarioLogado($conn, $usuario, $idUsuarioSessao);

        if ($updateUsuarioLogado) {

            $_SESSION['senha'] = $senhaNormal;
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['email'] = $usuario->getEmail();

            if ($_SESSION['perfil_idperfil'] == 2) {
                echo '
                <center>
                    <div class="alert alert-success" style="width: 455px;">
                        Usuário '; echo $usuario->getNome(); echo ' atualizado com sucesso!
                    </div>
                </center>';
                echo "
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_usuario_logado_coordenador.php'";
            } elseif ($_SESSION['perfil_idperfil'] == 1) {
                echo '
                <center>
                    <div class="alert alert-success" style="width: 455px;">
                        Usuário '; echo $usuario->getNome(); echo ' atualizado com sucesso!
                    </div>
                </center>';
                echo "
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_usuario_logado_admin.php'";
            }

        } elseif ($_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar usuário!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_form_usuario_logado_update.php'";
        } elseif ($_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar usuário!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_form_usuario_logado_update.php'";
        }

    }
