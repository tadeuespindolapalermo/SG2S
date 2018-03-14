<?php

	$erro_usuario = isset($_GET['erro_usuario']) ? $_GET['erro_usuario'] : 0;
	$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

 ?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="SG2S - Sistema de Geração da Grade Semestral" />
        <meta name="author" content="Tadeu Espíndola Palermo | Marcos Alexandre da Silva" />

        <title>SG2S - Sistema de Geração da Grade Semestral</title>

        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon/favicon.ico" />

        <!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>

	<body>

        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">SG2S</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../index.php">Voltar</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

	    <div class="container">

	    	<br /><br />

	    	<div class="col-md-4"></div>
	    	<div class="col-md-4">
	    		<h3><strong>Novo Usuário</strong></h3>
	    		<br />
				<form method="post" action="registra_usuario.php" id="formCadastrarse">
					<div class="form-group">
						<div class="form-group">
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="requiored">
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required="requiored">
						</div>

						<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required="requiored">
						<?php
							if($erro_usuario) {
								echo '<font color="#FF0000">Usuário já existe!</font>';
							}
						?>
					</div>

					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required="requiored">
						<?php
							if($erro_email) {
								echo '<font color="#FF0000">E-mail já existe!</font>';
							}
						 ?>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="requiored">
					</div>

					<button type="submit" class="btn btn-primary form-control">Cadastrar-se</button>
				</form>
			</div>



		</div>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>
