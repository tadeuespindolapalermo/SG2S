<?php

    require_once('../db/Conexao.class.php');

    $acesso = 'Aluno';
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
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

        header('Location: ../view/inscrevase.php?' . $retorno_get);
        die();
    }

    // INSERÇÃO COM PDO
    $sql = "INSERT INTO usuarios(acesso, matricula, nome, sobrenome, telefone, usuario, email, senha) VALUES (:acesso,:matricula,:nome,:sobrenome,:telefone,:usuario,:email,:senha)";

    $matriculaPDO = $matricula;
    $nomePDO = $nome;
    $acessoPDO = $acesso;
    $sobrenomePDO = $sobrenome;
    $telefonePDO = $telefone;
    $usuarioPDO = $usuario;
    $emailPDO = $email;
    $senhaPDO = $senha;

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':matricula', $matriculaPDO);
    $stmt->bindParam(':nome', $nomePDO);
    $stmt->bindParam(':acesso', $acessoPDO);
    $stmt->bindParam(':sobrenome', $sobrenomePDO);
    $stmt->bindParam(':telefone', $telefonePDO);
    $stmt->bindParam(':usuario', $usuarioPDO);
    $stmt->bindParam(':email', $emailPDO);
    $stmt->bindParam(':senha', $senhaPDO);

    if($stmt->execute()) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Usuário cadastrado com sucesso!!!\");
        </script>";
        header('Location: ../index.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar usuário!!!\");
        </script>";
        header('Location: inscrevase.php');
    }

    // INSERÇÃO SEM PDO
    // String SQL de inserção de usuário
    //$sql = "INSERT INTO usuarios(acesso, matricula, nome, sobrenome, telefone, usuario, email, senha) VALUES ('$acesso', '$matricula', '$nome', '$sobrenome', '$telefone', '$usuario', '$email', '$senha')";

    // Executa a query
    /*if (mysqli_query($link, $sql)) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Usuário cadastrado com sucesso!!!\");
        </script>";
        header('Location: ../index.php');
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao cadastrar usuário!!!\");
        </script>";
        header('Location: inscrevase.php');
    }*/
