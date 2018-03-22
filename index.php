<?php
    $erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>

<!DOCTYPE html>
<html ng-app="sg2s" lang="pt-br" >
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
		<!--<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>-->

        <!-- jquery sem cdn, fixo no código-->
        <script src="lib/jquery/jquery-2_2_4.min.js"></script>

        <script src="js/index.js"></script>
    </head>

    <body class="text-center" ng-controller="indexController">
        <form name="loginForm" class="form-signin" method="post" action="processamento/autenticacao_validar_acesso_login.php" id="formLogin">
            <img src="img/sg2s.png" alt="">
            <h1 ng-bind="titulo" class="h3 mb-3" style="font-weight: 900"></h1>

            <label for="inputEmail" class="sr-only">Usuário</label>
            <input ng-model="usuariologin" type="text" ng-required="true" id="campo_usuario" name="usuario" class="form-control" placeholder="Usuário" required autofocus />

            <label for="inputPassword" class="sr-only">Senha</label>
            <input ng-model="senhalogin" type="password" ng-required="true" id="campo_senha" name="senha" class="form-control" placeholder="Senha" required />

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="lembrar-me">Lembrar-me
                </label>
                <?php
                    echo '<br/>';
                    if($erro == 1) {
                        echo '<font color="#FF0000"><strong>Usuário e/ou senha inválido(s)!<strong></font>';
                    }
                 ?>
                <div ng-show="loginForm.usuario.$error.required && loginForm.usuario.$dirty" ng-messages="loginForm.usuario.$error">
                    <div ng-message="required" class="alert alert-danger">
                        Preencha o campo Usuário!
                    </div>
                </div>
                <div ng-show="loginForm.senha.$error.required && loginForm.senha.$dirty" ng-messages="loginForm.senha.$error">
                    <div ng-message="required" class="alert alert-danger">
                        Preencha o campo Senha!
                    </div>
                </div>
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" id="btn_login">Entrar</button>
            <small><a href="view/inscrevase_aluno.php">É Aluno? Cadastre-se</a></small>
            <p class="mt-5 mb-3 text-muted">&copy; SG2S 2018 | Faculdade JK</p>
        </form>

        <script src="lib/angularjs/angular.min.js"></script>
        <script src="lib/angularjs/angular-route.min.js"></script>
        <script src="js/app/app.js"></script>
        <script src="js/app/controllers.js"></script>
    </body>
</html>
