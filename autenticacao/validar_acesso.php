<?php

    session_start();

    require_once('../db/Conexao.class.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $sql = "SELECT nome, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $resultado_id = mysqli_query($link, $sql);

    if($resultado_id) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if (isset($dados_usuario['usuario'])) {

            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $_SESSION['email'] = $dados_usuario['email'];
            $_SESSION['nome'] = $dados_usuario['nome'];

            header('Location: ../view/home.php');
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor em contato com o administrador!';
    }
