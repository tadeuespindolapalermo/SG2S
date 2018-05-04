<?php
	session_start();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

	$erro_usuario = isset($_GET['erro_usuario']) ? $_GET['erro_usuario'] : 0;
	$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;

 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Cadastrar Usuário</div></strong></h3>
		<br />
		<form method="post" action="../controller/controller_form_usuario_cadastro.php" id="formCadastrarse">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

                <div class="form-group">
                    <select class="form-control" id="perfil" name="perfil" required="required" autofocus>
						<option value="">-Selecione o Perfil-</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Coordenador">Coordenador</option>
                    </select>
				</div>

				<div class="form-group">
					<input type="text" maxlength="60" class="form-control" id="nome" name="nome" placeholder="*Nome - Máximo 60 caracteres." required="required">
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="telefone" name="telefone" placeholder="*Telefone (xx) x xxxx-xxxx" required="required" autofocus>
				</div>

				<input type="text" maxlength="40" class="form-control" id="usuario" name="usuario" placeholder="*Usuário - Máximo 40 caracteres." required="required">
				<?php
					if($erro_usuario) {
						echo '<font color="#FF0000">Usuário já existe!</font>';
					}
				?>
			</div>

			<div class="form-group">
				<input type="email" maxlength="60" class="form-control" id="email" name="email" placeholder="*E-mail: nome@provedor.com - máx 60" required="required">
				<?php
					if($erro_email) {
						echo '<font color="#FF0000">E-mail já existe!</font>';
					}
				 ?>
			</div>

			<div class="form-group">
				<input type="password" maxlength="8" class="form-control" id="senha" name="senha" placeholder="*Senha - Máximo 8 dígitos." required="required">
			</div>
			<button type="submit" class="btn btn-outline-success form-control">Cadastrar</button>
		</form>
	</div>
</div>
