<?php

    session_start();

    require_once('../db/Conexao.class.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);
    $senhaNormal = $_POST['senha'];
    $perfilIdPerfil = 1;

    $sqlUsuario = "SELECT nome, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
    $sqlPerfilId = "SELECT perfil_idperfil, usuarios_idusuarios FROM usuario_perfil WHERE perfil_idperfil = '$perfilIdPerfil'";    

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $resultado_id = mysqli_query($link, $sqlUsuario);
    $resultado_perfil_id = mysqli_query($link, $sqlPerfilId);

    if($resultado_id) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        $dados_perfil = mysqli_fetch_array($resultado_perfil_id);
        if (isset($dados_usuario['usuario']) && isset($dados_perfil['usuarios_idusuarios'])) {

            $_SESSION['perfil_idperfil'] = $dados_perfil['perfil_idperfil'];
            $_SESSION['nome'] = $dados_usuario['nome'];
            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $_SESSION['email'] = $dados_usuario['email'];
            $_SESSION['senha'] = $senhaNormal;

            if($_SESSION['perfil_idperfil'] == 1) {
                header('Location: ../view/admin.php?pagina=home.php');
            }
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor entre em contato com o administrador!';
    }
