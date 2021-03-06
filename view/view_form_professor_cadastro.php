<?php
	session_start();
	ob_start();
	/*if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

	if ($_SESSION['perfil_idperfil'] == 1) {
		$url = 'view_admin.php';
	} elseif ($_SESSION['perfil_idperfil'] == 2) {
		$url = 'view_coordenador.php';
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
		<h3><strong><div style="margin-top: -50px; text-align: center;">Cadastrar Professor</div></strong></h3>
		<div style="text-align: center;"><small><strong>AVISO: 'CPF', 'RG' e 'E-mail' devem ser ÚNICOS!</strong></small></div>
		<br />
		<form name="formProfessor" method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_professor_cadastro.php" id="formProfessor">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
					<input type="text" maxlength="60" class="form-control" id="nome" name="nome" placeholder="*Nome - Até 60 caracteres." required="required" autofocus>
				</div>

				<div class="form-group">
					<input type="text" class="form-control" id="cpf" name="cpf" placeholder="*CPF: 999.999.999-99" required="required">
                    <?php
    					if($erro_cpf) {
    						echo '<font color="#FF0000">Professor com o CPF informado já existe ou foi enviado para a lixeira!</font>';
    					}
    				?>
				</div>

                <div class="form-group">
    				<input type="number" min="0" class="form-control" id="rg" name="rg" placeholder="*RG - Apenas números." required="required">
                    <?php
                        if($erro_rg) {
                            echo '<font color="#FF0000">Professor com o RG informado já existe ou foi enviado para a lixeira!</font>';
                        }
                    ?>
                </div>
			</div>

			<div class="form-group">
				<input type="email" maxlength="60" class="form-control" id="email" name="email" placeholder="*E-mail: nome@provedor.com - máx 60" required="required">
                <?php
                    if($erro_email) {
                        echo '<font color="#FF0000">Professor com o E-mail informado já existe ou foi enviado para a lixeira!</font>';
                    }
                ?>
			</div>

            <div class="form-group">
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="*Telefone (xx) x xxxx-xxxx" required="required">
            </div>
			<button id="btnCadastrarProf" onclick="validarCPF()" type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_professores_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>		
		</form>
	</div>
</div>
