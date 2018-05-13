<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $perfil = new Perfil();
    $usuario = new Usuarios();
    $usuarioDao = new UsuarioDao();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ..controller/controller_sair.php');
    }

    $perfil->setDescricao($_POST['perfil']);

    if ($perfil->getDescricao() == 'Administrador') {
        $perfil->setIdPerfil(1);
    } elseif ($perfil->getDescricao() == 'Coordenador') {
        $perfil->setIdPerfil(2);
    }

    $usuario->setNome($_POST['nome']);
    $usuario->setFone($_POST['telefone']);
    $usuario->setUsuario($_POST['usuario']);
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha(md5($_POST['senha'])); // md5 - senha criptografada com hash de 32 caracteres

    // Inserção do Usuário no Banco
    $cadastroUsuarioEfetuado = $usuarioDao->inserir($conn, $usuario);
    $cadastroPerfilUsuarioEfetuado = $usuarioDao->inserirPerfil($conn, $usuario, $perfil);

    if($cadastroUsuarioEfetuado && $cadastroPerfilUsuarioEfetuado) {
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Usuário cadastrado com sucesso!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";*/
        echo '
        <center>
            <div class="alert alert-success" style="width: 600px;">
              Usuário cadastrado com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar Usuário!!!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_form_usuario_cadastro.php'";
        //header('Location: ../view/view_admin.php?pagina=view_form_usuario_cadastro.php');
    }
