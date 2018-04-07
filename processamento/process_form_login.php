<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO PARA ACESSO A DADOS
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuarios = new Usuarios();
    $perfil = new Perfil();

    $usuarios->setUsuario($_POST['usuario']);
    $usuarios->setSenha(md5($_POST['senha']));
    $senhaNormal = $_POST['senha'];

    // VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
    $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha";
    $selectUsuario = $conn->prepare($sqlUsuario);
    $selectUsuario->bindValue(':usuario', $usuarios->getUsuario());
    $selectUsuario->bindValue(':senha', $usuarios->getSenha());
    $selectUsuario->execute();

    if ($selectUsuario) {

        $dados_usuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_usuario as $dados) {
            $usuarios->setIdUsuarios($dados['idusuarios']);
            $usuarios->setNome($dados['nome']);
            $usuarios->setEmail($dados['email']);
            $usuarios->setSenha($dados['senha']);
            $usuarios->setUsuario($dados['usuario']);
            $usuarioUsuario = $usuarios->getUsuario();
        }

        $sqlPerfilId = "SELECT perfil_idperfil FROM usuario_perfil WHERE usuarios_idusuarios = :idUsuario";
        $selectPerfilId = $conn->prepare($sqlPerfilId);
        $selectPerfilId->bindValue(':idUsuario', $usuarios->getIdUsuarios());
        $selectPerfilId->execute();

        $dados_perfil = $selectPerfilId->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_perfil as $dados) {
            $perfil->setIdPerfil($dados['perfil_idperfil']);
            $idPerfil = $perfil->getIdPerfil();
        }

        if (isset($usuarioUsuario) && isset($idPerfil)) {

            $_SESSION['perfil_idperfil'] = $perfil->getIdPerfil();
            $_SESSION['nome'] = $usuarios->getNome();
            $_SESSION['idusuarios'] = $usuarios->getIdUsuarios();
            $_SESSION['usuario'] = $usuarios->getUsuario();
            $_SESSION['email'] = $usuarios->getEmail();
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
