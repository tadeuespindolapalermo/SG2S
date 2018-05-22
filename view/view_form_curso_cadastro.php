<?php
	session_start();
	ob_start();

	if ($_SESSION['perfil_idperfil'] == 1) {
		$url = 'view_admin.php';
	} elseif ($_SESSION['perfil_idperfil'] == 2) {
		$url = 'view_coordenador.php';
	}

	/*if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

	$erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Cadastrar Curso</div></strong></h3>
		<small><strong>AVISO: 'Nome' deve ser ÚNICO!</strong></small><br/>
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_curso_cadastro.php" id="formCurso">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
					<input type="text" maxlength="60" class="form-control" id="nome" name="nome" placeholder="*Nome - Até 60 caracteres." required="required" autofocus>
                    <?php
    					if($erro_nome) {
    						echo '<font color="#FF0000">Curso já existe!</font>';
    					}
    				?>
				</div>

				<div class="form-group">
					<input type="text" maxlength="30" class="form-control" id="portaria" name="portaria" placeholder="*Portaria - Até 30 caracteres." required="required">
				</div>

				<input type="number" min="0.5" max="8.0" step="0.5" class="form-control" id="duracao" name="duracao" placeholder="*Duração (Anos) - Entre 0.5 à 8.0" required="required">

			</div>

			<div class="form-group">
				<select class="form-control" id="grau" name="grau" required="required">
					<option value="">-*Selecione o Grau-</option>
					<option value="Tecnólogo">Tecnólogo</option>
					<option value="Licenciatura">Licenciatura</option>
					<option value="Bacharelado">Bacharelado</option>
				</select>
			</div>

			<div class="form-group">
				<input type="number" min="0" max="29999" class="form-control" id="versaoMatriz" name="versaoMatriz" placeholder="*Versão da Matriz - Até 5 digitos." required="required">
			</div>

			<div class="form-group">
				<input type="date" class="form-control" id="dataPortaria" name="dataPortaria" placeholder="*Data Portaria: dd/mm/YYYY" required="required">
				<small>*Data da Portaria: dd/mm/YYYY</small>
			</div>

			<button type="submit" style="margin-bottom: 5px;" class="botao3d botao3d:hover"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_cursos_listagem.php"><button type="button" class="botao3d botao3d:hover"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
