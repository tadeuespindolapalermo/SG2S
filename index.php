<?php
    $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="SG2S - Sistema de Geração da Grade Semestral" />
        <meta name="author" content="Tadeu Espíndola Palermo | Marcos Alexandre da Silva" />
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon/favicon.ico" />

        <title>SG2S - Sistema de Geração da Grade Semestral</title>

        <!-- Bootstrap core CSS -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="css/signin.css" rel="stylesheet">

        <!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

        <script src="js/index.js"></script>
    </head>

    <body class="text-center">
        <form class="form-signin" method="post" action="autenticacao/validar_acesso.php" id="formLogin">
            <img src="img/sg2s.png" alt="">
            <h1 class="h3 mb-3" style="font-weight: 900">SG2S - Login</h1>

            <label for="inputEmail" class="sr-only">Usuário</label>
            <input type="text" id="campo_usuario" name="usuario" class="form-control" placeholder="Usuário" required autofocus />

            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" id="campo_senha" name="senha" class="form-control" placeholder="Senha" required />

            <div class="checkbox mb-3">
                <?php
                    echo '<br/>';
                    if($erro == 1) {
                        echo '<font color="#FF0000"><strong>Usuário e/ou senha inválido(s)!<strong></font>';
                    }
                 ?>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn_login">Entrar</button>
            <small><a href="autenticacao/inscrevase.php">Cadastre-se</a></small>
            <p class="mt-5 mb-3 text-muted">&copy; SG2S 2018 | Faculdade JK</p>
        </form>
    </body>
</html>
