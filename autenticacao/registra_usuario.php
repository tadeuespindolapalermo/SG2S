<?php

    require_once('../db/Conexao.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    // String SQL de inserção de usuário
    $sql = "INSERT INTO usuarios(usuario, email, senha) VALUES ('$usuario', '$email', '$senha')";

    // Executa a query
    if (mysqli_query($link, $sql)) {
        echo 'Usuário registrado com sucesso!';
    } else {
        echo 'Erro ao registrar o usuário!';
    }
