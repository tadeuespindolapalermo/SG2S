<?php
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $disciplina = new Disciplina();
    $disciplinaDao = new DisciplinaDao();

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

    $selectDisciplina = $disciplinaDao->listarCombo($conn);

	$erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Cadastrar Disciplina</div></strong></h3>
		<small><strong>AVISO: 'Nome' deve ser ÚNICO!</strong></small><br/>
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_disciplina_cadastro.php" id="formDisciplina">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

                <div class="form-group">
                    <select class="form-control" id="curso_idcurso" name="curso_idcurso" required="required" autofocus>
						<option value="">-*Selecione o Curso-</option>
                        <?php
							while ($linhaDisciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC)) {
								foreach ($linhaDisciplina as $dados) {
									$disciplina->setCursoIdCurso($dados['idcurso']);
									$disciplina->setCursoNome($dados['nome']);
									echo '<option value="'.$disciplina->getCursoIdCurso().'">'.$disciplina->getCursoNome().'</option>';
								}
							}
                        ?>
                    </select>
				</div>

				<div class="form-group">
					<input type="text" maxlength="100" class="form-control" id="nomeDisciplina" name="nomeDisciplina" placeholder="*Nome - Até 100 caracteres." required="required">
                    <?php
    					if($erro_nome) {
    						echo '<font color="#FF0000">Disciplina já existe!</font>';
    					}
    				?>
				</div>

				<div class="form-group">
					<input type="number" min="1.00" max="999.99" class="form-control" id="cargaHoraria" name="cargaHoraria" placeholder="*Carga Horária - Entre 1.00 à 999.99" required="required">
				</div>

				<input type="number" min="0" max="9" class="form-control" id="credito" name="credito" placeholder="*Crédito - Entre 0 à 9" required="required">

			</div>

			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_disciplinas_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
