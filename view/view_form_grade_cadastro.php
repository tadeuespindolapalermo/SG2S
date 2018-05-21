<?php
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $grade = new Grade();
    $gradeDao = new GradeDao();

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

    $selectGrade = $gradeDao->listarCombo($conn);
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Cadastrar Grade</div></strong></h3>
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_cadastro.php" id="formGrade">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
	                <select class="form-control" id="curso_idcurso" name="curso_idcurso" required autofocus>
	                    <option value="">-*Selecione o Curso-</option>
	                    <?php
	                        while ($linhaGrade = $selectGrade->fetchAll(PDO::FETCH_ASSOC)) {
	                            foreach ($linhaGrade as $dados) {
	                                $grade->setCursoIdCurso($dados['idcurso']);
	                                $grade->setCursoNome($dados['nome']);
	                                echo '<option value="'.$grade->getCursoIdCurso().'">'.$grade->getCursoNome().'</option>';
	                            }
	                        }
	                    ?>
	                </select>
	            </div>

                <div class="form-group">
                    <select class="form-control" id="semestreLetivo" name="semestreLetivo" required>
						<option value="">-*Selecione o Semestre do Ano Letivo-</option>
                        <option value="1">1º Semestre</option>
                        <option value="2">2º Semestre</option>
                    </select>
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
				</div>

			</div>			

			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_grades_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
