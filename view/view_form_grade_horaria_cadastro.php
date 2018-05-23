<div class="container">
	<h1><strong>EM CONSTRUÇÃO!<strong></h1>
</div>
<?php	
	exit();
	session_start();
	ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeHoraria = new GradeHoraria();
    $gradeHorariaDao = new GradeHorariaDao();

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

    //$selectGradeHoraria = $gradeHorariaDao->listarCombo($conn);

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
		<h3><strong><div style="margin-top: -50px;">Cadastrar Grade Horária</div></strong></h3>
		<!-- VERIFICAR COM GEORGE A LÓGICA DE NEGÓCIO PARA REPETIÇÃO DE GRADE HORÁRIA-->
		<!--<small><strong>AVISO: 'Ano', 'Semestre' e 'Curso': trinca única!<strong></small><br/>-->
		<br />
		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_horaria_cadastro.php" id="formGradeHoraria">

			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>
			</div>

			<button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_grades_horarias_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
		</form>
	</div>
</div>
