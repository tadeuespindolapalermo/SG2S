<?php

    require_once('../db/Conexao.class.php');

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $resultado_id = mysqli_query($link, $sql);

    if($resultado_id) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if (isset($dados_usuario['usuario'])) {
            header('Location: ../view/home.html');
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor em contato com o administrador!';
    }
