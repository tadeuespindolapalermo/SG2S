<?php

    require_once('../db/Conexao.class.php');

    $perfil = $_POST['perfil'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // md5 - senha criptografada com hash de 32 caracteres

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    // PDO
    $conn = $objConexao->getConnection();

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
        /*echo "
        <script type=\"text/javascript\">
            alert(\"Usuário já existe!\");
        </script>";*/
        header('Location: ../view/admin.php?pagina=cadastros_usuarios_admin.php&' . $retorno_get);
        //header('Location: ../view/admin.php?pagina=cadastros_usuarios_admin.php');
        die();
    }

    // INSERÇÃO COM PDO
    $sqlUsuario = "INSERT INTO usuarios(nome, fone, email, usuario, senha) VALUES (:nome,:fone,:email,:usuario,:senha)";

    $nomePDO = $nome;
    $telefonePDO = $telefone;
    $usuarioPDO = $usuario;
    $emailPDO = $email;
    $senhaPDO = $senha;

    $stmt = $conn->prepare($sqlUsuario);

    $stmt->bindParam(':nome', $nomePDO);
    $stmt->bindParam(':fone', $telefonePDO);
    $stmt->bindParam(':email', $emailPDO);
    $stmt->bindParam(':usuario', $usuarioPDO);
    $stmt->bindParam(':senha', $senhaPDO);

    $cadastroEfetuado = $stmt->execute();

    if($cadastroEfetuado) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Usuário cadastrado com sucesso!!!\");
        </script>";
        header('Location: ../view/admin.php?pagina=usuarios_listagem.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar usuário!!!\");
        </script>";
        header('Location: ../view/cadastros_usuarios_admin.php');
    }
