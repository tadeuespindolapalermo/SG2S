<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO PARA ACESSO A DADOS
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuario = new Usuarios();
    $perfil = new Perfil();
    $usuarioDao = new UsuarioDao();

    $usuario->setUsuario($_POST['usuario']);
    $usuario->setSenha(md5($_POST['senha']));
    $senhaNormal = $_POST['senha'];

    $selectUsuario = $usuarioDao->buscarUsuarioLogin($conn, $usuario);

    if ($selectUsuario) {

        $dados_usuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_usuario as $dados) {
            $usuario->setIdUsuarios($dados['idusuarios']);
            $usuario->setNome($dados['nome']);
            $usuario->setEmail($dados['email']);
            $usuario->setSenha($dados['senha']);
            $usuario->setUsuario($dados['usuario']);
            $usuarioUsuario = $usuario->getUsuario();
        }

        $selectPerfilId = $usuarioDao->buscarPerfilUsuarioLogin($conn, $usuario);

        $dados_perfil = $selectPerfilId->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_perfil as $dados) {
            $perfil->setIdPerfil($dados['perfil_idperfil']);
            $idPerfil = $perfil->getIdPerfil();
        }

        if (isset($usuarioUsuario) && isset($idPerfil)) {

            $_SESSION['perfil_idperfil'] = $perfil->getIdPerfil();
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['idusuarios'] = $usuario->getIdUsuarios();
            $_SESSION['usuario'] = $usuario->getUsuario();
            $_SESSION['email'] = $usuario->getEmail();
            $_SESSION['senha'] = $senhaNormal;

            if ($perfil->getIdPerfil() == 1) {
                header('Location: ../view/view_admin.php?pagina=view_home.php');
                $_SESSION['senha'] = $senhaNormal;
            } elseif ($perfil->getIdPerfil() == 2) {
                header('Location: ../view/view_coordenador.php?pagina=view_home.php');
                $_SESSION['senha'] = $senhaNormal;
            }
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor entre em contato com o administrador!';
    }
