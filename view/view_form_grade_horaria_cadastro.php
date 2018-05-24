<?php
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeHoraria = new GradeHoraria();
	$gradeHorariaCurso = new GradeHoraria();
    $gradeHorariaDao = new GradeHorariaDao();

	$idGradeSemestral = $_GET['idGradeSemestral'];
	$gradeHorariaCurso->setIdGradeSemestral($idGradeSemestral);

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

    //$selectCursoGradeHoraria = $gradeHorariaDao->listarComboCurso($conn);

	$selectGradeHoraria = $gradeHorariaDao->buscarPorId($conn, $idGradeSemestral);
    $linhaGradeHoraria = $selectGradeHoraria->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaGradeHoraria as $dados) {
        $gradeHorariaCurso->setIdCursoGradeSemestral($dados['curso_idcurso']);
        $gradeHorariaCurso->setCursoNome($dados['nome']);
    }

	// DEBUG
	/*echo $gradeHorariaCurso->getIdCursoGradeSemestral();
	echo $gradeHorariaCurso->getCursoNome();
	exit();*/

	// VERIFICAR COM GEORGE A LÓGICA DE NEGÓCIO PARA REPETIÇÃO DE GRADE HORÁRIA
	// ESTA ABAIXO É UTILIZADA PARA GRADE SEMESTRAL
	/*$erro_ano = isset($_GET['erro_ano']) ? $_GET['erro_ano'] : 0;
	$erro_semestre = isset($_GET['erro_semestre']) ? $_GET['erro_semestre'] : 0;
	$erro_curso = isset($_GET['erro_curso']) ? $_GET['erro_curso'] : 0;*/
 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px; text-align: center;">Cadastrar Grade Horária</div></strong></h3>
		<!-- VERIFICAR COM GEORGE A LÓGICA DE NEGÓCIO PARA REPETIÇÃO DE GRADE HORÁRIA-->
		<!--<small><strong>AVISO: 'Ano', 'Semestre' e 'Curso': trinca única!<strong></small><br/>-->
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_horaria_cadastro.php" id="formGradeHoraria">

			<div class="form-group">
				<div style="text-align: center;"><small><strong>*Campos Obrigatórios</strong></small></div>

				<?php echo '<br/>
				<small><strong>ID Grade Semestral</strong></small>
				<div class="form-group">
					<input style="width: 105px;" type="text" class="form-control" id="idGradeSemestral" name="idGradeSemestral"
					placeholder="*ID da Grade Horária" value="'.$gradeHorariaCurso->getIdGradeSemestral().'" disabled>
				</div>';?>

				<?php echo '
				<div class="form-group">
					<strong>ID do Curso de:<br/><font color="blue">'.$gradeHorariaCurso->getCursoNome().'</font></strong>
					<input type="text" class="form-control" id="idCursoGradeSemestral" name="idCursoGradeSemestral"
					placeholder="*Curso da Grade Horária" value="'.$gradeHorariaCurso->getIdCursoGradeSemestral().'" disabled>
				</div>';?>

				<div class="form-group">
					<input type="number" min="0" max="99" class="form-control" id="sala" name="sala"
					placeholder="*Sala (Presencial) - Até 2 números" required autofocus>
					<!-- Local da aula presencial. -->
				</div>

				<div class="form-group">
					<input type="number" min="0" max="999" class="form-control" id="quantidadeAlunos" name="quantidadeAlunos"
					placeholder="*Quantidade Alunos - Até 3 números" required>
					<!-- Quantidade de alunos das turmas somados. -->
				</div>

				<div class="form-group">
					<input type="text" maxlength="50" class="form-control" id="turmas" name="turmas"
					placeholder="*Turmas - Ex.: TADS (TADS2A)" required>
					<!-- PED - Pedagogia (PED6B)
						 LET - Letras (LET1A)
						 TADS (TADS2A)-->
				</div>

				<div class="form-group">
					<input type="number" min="0" max="8" class="form-control" id="periodoCurso" name="periodoCurso"
					placeholder="*Período Curso (Semestre) - de 1 a 8" required>
					<!-- Dependendo do curso:
                         Tecnólogo: 1 a 5
					 	 Licenciatura e bacharelado: 1 a 8.
						 Licenciatura grade antiga: 1 a 7.-->
				</div>

				<div class="form-group">
					<input type="number" min="1" max="7" class="form-control" id="diaSemana" name="diaSemana"
					placeholder="*Dia Semana - de 1 (Dom) a 7 (Sab)" required>
					<!-- Segunda a sábado:
						 - 1: Domingo
						 - 2: Segunda
						 - 3: Terça
						 - 4: Quarta
						 - 5: Quinta
						 - 6: Sexta
						 - 7: Sábado-->
				</div>

				<div class="form-group">
					<input type="number" min="0" max="1" class="form-control" id="ead" name="ead"
					placeholder="*EAD: [ 0 ] Não - [ 1 ] Sim" required>
					<!-- 0 - Não é EAD
						 1 - EAD-->
				</div>

				<!-- CASO SEJA NECESSÁRIO ALTERAR O CURSO DE UMA GRADE SEMESTRAL-->
				<!--<div class="form-group">
	                <select class="form-control" id="idCursoGradeHoraria" name="idCursoGradeHoraria" required>
	                    <option value="">-*Selecione o Curso-</option>-->
	                    <?php
	                       /* while ($linhaCursoGradeHoraria = $selectCursoGradeHoraria->fetchAll(PDO::FETCH_ASSOC)) {
	                            foreach ($linhaCursoGradeHoraria as $dados) {
	                                $gradeHoraria->setIdCursoGradeSemestral($dados['idcurso']);
	                                $gradeHoraria->setCursoNome($dados['nome']);
	                                echo '<option value="'.$gradeHoraria->getIdCursoGradeSemestral().'">'.$gradeHoraria->getCursoNome().'</option>';
	                            }
	                        }*/
	                    ?>
	                <!--</select>
	            </div>-->

			</div>

			<button type="submit" onclick="alterarDisabledCadastroGradeHoraria()" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_grades_semestrais_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
