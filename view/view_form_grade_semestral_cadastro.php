<?php
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeSemestral = new GradeSemestral();
    $gradeSemestralDao = new GradeSemestralDao();

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

    $selectGradeSemestral = $gradeSemestralDao->listarCombo($conn);

	$erro_ano = isset($_GET['erro_ano']) ? $_GET['erro_ano'] : 0;
	$erro_semestre = isset($_GET['erro_semestre']) ? $_GET['erro_semestre'] : 0;
	$erro_curso = isset($_GET['erro_curso']) ? $_GET['erro_curso'] : 0;
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px; text-align: center;">Cadastrar Grade Semestral</div></strong></h3>
		<div style="text-align: center;"><small ><strong>AVISO: 'Ano', 'Semestre' e 'Curso': trinca única!<strong></small></div>
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_semestral_cadastro.php" id="formGradeSemestral">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
	                <select class="form-control" id="curso_idcurso" name="curso_idcurso" required autofocus>
	                    <option value="">-*Selecione o Curso-</option>
	                    <?php
	                        while ($linhaGradeSemestral = $selectGradeSemestral->fetchAll(PDO::FETCH_ASSOC)) {
	                            foreach ($linhaGradeSemestral as $dados) {
	                                $gradeSemestral->setCursoIdCurso($dados['idcurso']);
	                                $gradeSemestral->setCursoNome($dados['nome']);
	                                echo '<option value="'.$gradeSemestral->getCursoIdCurso().'">'.$gradeSemestral->getCursoNome().'</option>';
	                            }
	                        }
	                    ?>
	                </select>
					<?php
    					if($erro_curso) {
    						echo '<font color="#FF0000">Grade já existe!</font>';
    					}
    				?>
	            </div>

                <div class="form-group">
                    <select class="form-control" id="semestreLetivo" name="semestreLetivo" required>
						<option value="">-*Selecione o Semestre Letivo-</option>
                        <option value="1">1º Semestre</option>
                        <option value="2">2º Semestre</option>
                    </select>
					<?php
    					if($erro_semestre) {
    						echo '<font color="#FF0000">Grade já existe!</font>';
    					}
    				?>
				</div>

                <div class="form-group">
                    <select class="form-control" id="turno" name="turno" required>
						<option value="">-*Selecione o Turno-</option>
                        <option value="Matutino">Matutino - 08:00 às 12:00</option>
                        <option value="Vespertino">Vespertino - 13:00 às 18:00</option>
                        <option value="Noturno">Noturno - 19:15 às 22:00</option>
                    </select>
				</div>

				<div class="form-group">
					<input type="number" min="2000" max="9999" class="form-control" id="anoLetivo" name="anoLetivo"
					placeholder="*Ano Letivo - Até 4 números" required>
					<?php
    					if($erro_ano) {
    						echo '<font color="#FF0000">Grade já existe!</font>';
    					}
    				?>
				</div>

			</div>

			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_grades_semestrais_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
