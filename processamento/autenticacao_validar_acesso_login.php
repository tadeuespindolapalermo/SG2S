<?php
    session_start();

    require('../db/Config.inc.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);
    $senhaNormal = $_POST['senha'];

    // CONEXÃO COM PDO PARA ACESSO A DADOS
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    // VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
    $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha";
    $selectUsuario = $conn->prepare($sqlUsuario);
    $selectUsuario->bindValue(':usuario', $usuario);
    $selectUsuario->bindValue(':senha', $senha);
    $selectUsuario->execute();

    if ($selectUsuario) {

        $dados_usuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_usuario as $dados) {
            $idUsuario = $dados['idusuarios'];
            $nomeUsuario = $dados['nome'];
            $usuarioUsuario = $dados['usuario'];
            $emailUsuario = $dados['email'];
            $senhaUsuario = $dados['senha'];
        }

        $sqlPerfilId = "SELECT perfil_idperfil FROM usuario_perfil WHERE usuarios_idusuarios = :idUsuario";
        $selectPerfilId = $conn->prepare($sqlPerfilId);
        $selectPerfilId->bindValue(':idUsuario', $idUsuario);
        $selectPerfilId->execute();

        $dados_perfil = $selectPerfilId->fetchAll(PDO::FETCH_ASSOC);
        foreach($dados_perfil as $dados) {
            $idPerfil = $dados['perfil_idperfil'];
        }

        if (isset($usuarioUsuario) && isset($idPerfil)) {

            $_SESSION['perfil_idperfil'] = $idPerfil;
            $_SESSION['nome'] = $nomeUsuario;
            $_SESSION['idusuarios'] = $idUsuario;
            $_SESSION['usuario'] = $usuarioUsuario;
            $_SESSION['email'] = $emailUsuario;
            $_SESSION['senha'] = $senhaUsuario;

            if ($idPerfil == 1) {
                header('Location: ../view/admin.php?pagina=home.php');
                $_SESSION['senha'] = $senhaNormal;
            } elseif ($idPerfil == 2) {
                header('Location: ../view/coordenador.php?pagina=home.php');
                $_SESSION['senha'] = $senhaNormal;
            }
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor entre em contato com o administrador!';
    }
