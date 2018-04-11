<?php
	session_start();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

	$erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Novo Curso</div></strong></h3>
		<br />
		<form method="post" action="../controller/controller_form_curso_cadastro.php" id="formCurso">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
					<input type="text" class="form-control" id="nome" name="nome" placeholder="*Nome" required="required" autofocus>
                    <?php
    					if($erro_nome) {
    						echo '<font color="#FF0000">Curso já existe!</font>';
    					}
    				?>
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="portaria" name="portaria" placeholder="*Portaria" required="required" autofocus>
				</div>

				<input type="number" class="form-control" id="duracao" name="duracao" placeholder="*Duração: X.X" required="required">

			</div>

			<div class="form-group">
				<input type="text" class="form-control" id="grau" name="grau" placeholder="*Grau: Técnologo, Bacharelado..." required="required">
			</div>

			<div class="form-group">
				<input type="date" class="form-control" id="dataPortaria" name="dataPortaria" placeholder="*Data Portaria: dd/mm/YYYY" required="required">
			</div>
			<button type="submit" class="btn btn-primary form-control">Cadastrar</button>
		</form>
	</div>
</div>
