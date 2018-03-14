<?php

    require_once('../db/Conexao.class.php');

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // md5 - senha criptografada com hash de 32 caracteres

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $usuario_existe = false;
    $email_existe = false;

    // Verifica se o usuário já existe na base de dados
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";

    if ($resultado_id = mysqli_query($link, $sql)) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if(isset($dados_usuario['usuario'])) {
            $usuario_existe = true;
        }
    } else {
        echo 'Erro ao tentar localizar o registro de usuário!';
    }

    // Verifica se o e-mail já existe na base de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";

    if ($resultado_id = mysqli_query($link, $sql)) {
        $dados_usuario = mysqli_fetch_array($resultado_id);
        if(isset($dados_usuario['email'])) {
            $email_existe = true;
        }
    } else {
        echo 'Erro ao tentar localizar o registro de e-mail!';
    }

    if ($usuario_existe || $email_existe) {

        $retorno_get = '';

        if ($usuario_existe) {
            $retorno_get.= "erro_usuario=1&";
        }

        if ($email_existe) {
            $retorno_get.= "erro_email=1&";
        }

        header('Location: inscrevase.php?' . $retorno_get);
        die();
    }

    // String SQL de inserção de usuário
    $sql = "INSERT INTO usuarios(nome, sobrenome, usuario, email, senha) VALUES ('$nome', '$sobrenome', '$usuario', '$email', '$senha')";

    // Executa a query
    if (mysqli_query($link, $sql)) {
        echo 'Usuário registrado com sucesso!';
    } else {
        echo 'Erro ao registrar o usuário!';
    }
