<?php

    session_start();

    require_once('../db/Conexao.class.php');

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);
    $senhaNormal = $_POST['senha'];

    $sql = "SELECT nome, usuario, email, acesso FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $resultado_id = mysqli_query($link, $sql);

    if($resultado_id) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if (isset($dados_usuario['usuario'])) {

            $_SESSION['nome'] = $dados_usuario['nome'];
            $_SESSION['usuario'] = $dados_usuario['usuario'];
            $_SESSION['email'] = $dados_usuario['email'];
            $_SESSION['senha'] = $senhaNormal;
            $_SESSION['acesso'] = $dados_usuario['acesso'];

            if($_SESSION['acesso'] == 'Administrador') {
                header('Location: ../view/admin.php?pagina=template-model.html');
            } elseif ($_SESSION['acesso'] == 'Aluno') {
                header('Location: ../view/aluno.php?pagina=template-model.html');
            }
            
        } else {
            header('Location: ../index.php?erro=1');
        }
    } else {
        echo 'Erro na execução da consulta, favor entre em contato com o administrador!';
    }
