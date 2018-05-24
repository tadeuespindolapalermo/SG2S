<?php
	session_start();
	ob_start();
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
		<h3><strong><div style="margin-top: -50px; text-align: center;">Cadastrar Usuário</div></strong></h3>
		<div style="text-align: center;"><small><strong>AVISO: 'Usuário' e 'E-mail' devem ser ÚNICOS!<strong></small></div>
		<br />
		<form method="post" action="view_admin.php?pagina=../controller/controller_form_usuario_cadastro.php" id="formCadastrarse">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

                <div class="form-group">
                    <select class="form-control" id="perfil" name="perfil" required="required" autofocus>
						<option value="">-*Selecione o Perfil-</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Coordenador">Coordenador</option>
                    </select>
				</div>

				<div class="form-group">
					<input type="text" maxlength="60" class="form-control" id="nome" name="nome" placeholder="*Nome - Máximo 60 caracteres." required>
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="telefone" name="telefone" placeholder="*Telefone (xx) x xxxx-xxxx" required>
				</div>

				<input type="text" maxlength="40" class="form-control" id="usuario" name="usuario" placeholder="*Usuário - Máximo 40 caracteres." required>
				<?php
					if($erro_usuario) {
						echo '<font color="#FF0000">Usuário já existe!</font>';
					}
				?>
			</div>

			<div class="form-group">
				<input type="email" maxlength="60" class="form-control" id="email" name="email" placeholder="*E-mail: nome@provedor.com - máx 60" required>
				<?php
					if($erro_email) {
						echo '<font color="#FF0000">E-mail já existe!</font>';
					}
				 ?>
			</div>

			<div class="form-group">
				<small>ATENÇÃO: Senha apenas com 8 caracteres.</small><br/>
				<small>MÍNIMO: 1 número, 1 letra maiúscula e 1 letra minúscula.</small>
				<input type="password" pattern="^(?=.*[a-zç])(?=.*[A-ZÇ])(?=.*\d)[\S\s]{8,}$" placeholder="*Somente 8 caracteres" maxlength="8" class="form-control" id="senha" name="senha" required>
			</div>
			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="view_admin.php?pagina=view_usuarios_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
