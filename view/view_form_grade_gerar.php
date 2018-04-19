<?php
	session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    // GRADE
    $grade = new Grade();
    $gradeDao = new GradeDao();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectGrade = $gradeDao->listarCombo($conn);


 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-4">
		<br />
		<h3><strong><div style="margin-top: -50px;">Gerar Grade Semestral</div></strong></h3>
		<br />
		<form method="post" action="../controller/controller_form_grade_gerar.php" id="formGradeGerar">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>



			    <button type="submit" class="btn btn-primary form-control">Cadastrar</button>
            </div>
		</form>
    </div>
</div>
