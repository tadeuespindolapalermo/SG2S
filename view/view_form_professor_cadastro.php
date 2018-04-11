<?php
	session_start();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

	$erro_cpf = isset($_GET['erro_cpf']) ? $_GET['erro_cpf'] : 0;
    $erro_rg = isset($_GET['erro_rg']) ? $_GET['erro_rg'] : 0;
    $erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Novo Professor</div></strong></h3>
		<br />
		<form method="post" action="../controller/controller_form_professor_cadastro.php" id="formProfessor">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
					<input type="text" class="form-control" id="nome" name="nome" placeholder="*Nome" required="required" autofocus>
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="cpf" name="cpf" placeholder="*CPF: 999.999.999-99" required="required">
                    <?php
    					if($erro_cpf) {
    						echo '<font color="#FF0000">CPF já existe ou o Professor foi mantido na base de dados!</font>';
    					}
    				?>
				</div>

                <div class="form-group">
    				<input type="text" class="form-control" id="rg" name="rg" placeholder="*RG" required="required">
                    <?php
                        if($erro_rg) {
                            echo '<font color="#FF0000">RG já existe ou o Professor foi mantido na base de dados!</font>';
                        }
                    ?>
                </div>
			</div>

			<div class="form-group">
				<input type="email" class="form-control" id="email" name="email" placeholder="*E-mail: nome@provedor.com" required="required">
                <?php
                    if($erro_email) {
                        echo '<font color="#FF0000">E-mail já existe ou o Professor foi mantido na base de dados!</font>';
                    }
                ?>
			</div>

            <div class="form-group">
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="*Telefone (xx) x xxxx-xxxx" required="required">
            </div>
			<button type="submit" class="btn btn-primary form-control">Cadastrar</button>
		</form>
	</div>
</div>
