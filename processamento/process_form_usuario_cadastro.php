<?php
    session_start();

    require('../db/Config.inc.php');

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    $perfil = $_POST['perfil'];

    if ($perfil == 'Administrador') {
        $perfil = 1;
    } elseif ($perfil == 'Coordenador') {
        $perfil = 2;
    }

    $nome = $_POST['nome'];
    $fone = $_POST['telefone'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // md5 - senha criptografada com hash de 32 caracteres

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuario_existe = false;
    $email_existe = false;

    // VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
    $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $selectUsuario = $conn->prepare($sqlUsuario);
    $selectUsuario->bindValue(':usuario', $usuario);
    $selectUsuario->execute();

    if ($selectUsuario->rowCount() >= 1) {
        $dados_usuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dados_usuario as $dados)
            $usuario_existe = isset($dados["usuario"]);

    } else {
        echo 'Erro ao tentar localizar o registro de usuário!';
    }
    // -------------------------------------------------------------

    // VERIFICA SE O E-MAIL INFORMADO EXISTE NO SISTEMA
    $sqlEmail = "SELECT * FROM usuarios WHERE email = :email";
    $selectEmail = $conn->prepare($sqlEmail);
    $selectEmail->bindValue(':email', $email);
    $selectEmail->execute();

    if ($selectEmail->rowCount() >= 1) {
        $dados_usuario = $selectEmail->fetchAll(PDO::FETCH_ASSOC);

        foreach($dados_usuario as $dados)
            $email_existe = isset($dados["email"]);

    } else {
        echo 'Erro ao tentar localizar o registro de usuário!';
    }
    // -----------------------------------------------------

    if ($usuario_existe || $email_existe) {

        $retorno_get = '';

        if ($usuario_existe) {
            $retorno_get.= "erro_usuario=1&";
        }

        if ($email_existe) {
            $retorno_get.= "erro_email=1&";
        }
        header('Location: ../view/view_admin.php?pagina=view_form_usuario_cadastro.php&' . $retorno_get);
        die();
    }

    // --------------------------------------------------

    // INSERÇÃO DE USUÁRIO COM PDO
    try {
        $sqlUsuario = "INSERT INTO usuarios(nome, fone, email, usuario, senha) VALUES (?, ?, ?, ?, ?)";

        $stmtCreateUsuario = $conn->prepare($sqlUsuario);

        $stmtCreateUsuario->bindParam(1, $nome, PDO::PARAM_STR, 60);
        $stmtCreateUsuario->bindParam(2, $fone, PDO::PARAM_STR, 16);
        $stmtCreateUsuario->bindParam(3, $email, PDO::PARAM_STR, 60);
        $stmtCreateUsuario->bindParam(4, $usuario, PDO::PARAM_STR, 40);
        $stmtCreateUsuario->bindParam(5, $senha, PDO::PARAM_STR, 32);

        $cadastroUsuarioEfetuado = $stmtCreateUsuario->execute();
        // -----------------------------------------

        // ------------------------------------------
        // BUSCAR ID DO USUÁRIO INSERIDO
        $sqlIdUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $selectIdUsuario = $conn->prepare($sqlIdUsuario);
        $selectIdUsuario->bindValue(':usuario', $usuario);
        $selectIdUsuario->execute();

        if ($selectIdUsuario->rowCount() >= 1) {
            $dados_id_usuario = $selectIdUsuario->fetchAll(PDO::FETCH_ASSOC);

            foreach($dados_id_usuario as $dados_id)
                $id_usuario_inserido = $dados_id['idusuarios'];
        }
        // --------------------------------------------------

        // INSERÇÃO DE PERFIL DO USUÁRIO COM PDO
        $sqlPerfilUsuario = "INSERT INTO usuario_perfil(usuarios_idusuarios, perfil_idperfil) VALUES (?, ?)";

        $stmtCreatePerfil = $conn->prepare($sqlPerfilUsuario);

        $stmtCreatePerfil->bindParam(1, $id_usuario_inserido, PDO::PARAM_INT, 11);
        $stmtCreatePerfil->bindParam(2, $perfil, PDO::PARAM_INT, 11);

        $cadastroPerfilUsuarioEfetuado = $stmtCreatePerfil->execute();
        // -----------------------------------------

        // VALIDAÇÃO DA INSERÇÃO DO USUÁRIO E DO PERFIL
        if($cadastroUsuarioEfetuado && $cadastroPerfilUsuarioEfetuado) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Usuário cadastrado com sucesso!!!\");
            </script>";
            header('Location: ../view/view_admin.php?pagina=view_usuarios_listagem.php');
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao cadastrar usuário!!!\");
            </script>";
            header('Location: ../view/view_admin.php?pagina=view_form_usuario_cadastro.php');
        }
    } catch (PDOException $e) {
        PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
    }
