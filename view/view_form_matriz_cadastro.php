<?php
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $matriz = new Matriz();
    $matrizDao = new MatrizDao();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectMatriz = $matrizDao->listarCombo($conn);

	$erro_nome = isset($_GET['erro_nome']) ? $_GET['erro_nome'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Cadastrar Matriz (Disciplina)</div></strong></h3>
		<small>AVISO: 'Nome' deve ser ÚNICO!</small><br/>
		<br />
		<form method="post" action="view_admin.php?pagina=../controller/controller_form_matriz_cadastro.php" id="formMatriz">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

                <div class="form-group">
                    <select class="form-control" id="curso_idcurso" name="curso_idcurso" required="required" autofocus>
						<option value="">-*Selecione o Curso-</option>
                        <?php
							while ($linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC)) {
								foreach ($linhaMatriz as $dados) {
									$matriz->setCursoIdCurso($dados['idcurso']);
									$matriz->setCursoNome($dados['nome']);
									echo '<option value="'.$matriz->getCursoIdCurso().'">'.$matriz->getCursoNome().'</option>';
								}
							}
                        ?>
                    </select>
				</div>

				<div class="form-group">
					<input type="text" maxlength="100" class="form-control" id="nomeMatriz" name="nomeMatriz" placeholder="*Nome - Até 100 caracteres." required="required">
                    <?php
    					if($erro_nome) {
    						echo '<font color="#FF0000">Matriz já existe!</font>';
    					}
    				?>
				</div>

				<div class="form-group">
					<input type="number" min="1.00" max="999.99" class="form-control" id="cargaHoraria" name="cargaHoraria" placeholder="*Carga Horária - Entre 1.00 à 999.99" required="required">
				</div>

				<input type="number" min="0" max="9" class="form-control" id="credito" name="credito" placeholder="*Crédito - Entre 0 à 9" required="required">

			</div>

			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="view_admin.php?pagina=view_matrizes_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
