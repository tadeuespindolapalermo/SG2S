<?php
	session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

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
		<h3><strong><div style="margin-top: -50px;">Nova Grade</div></strong></h3>
		<br />
		<form method="post" action="../controller/controller_form_grade_cadastro.php" id="formGrade">
			<div class="form-group">
				<small><strong>*Campos Obrigatórios</strong></small>

				<div class="form-group">
					<input type="number" min="2000" max="9999"class="form-control" id="anoLetivo" name="anoLetivo"
                    placeholder="*Ano Letivo (9999)" required="required" autofocus
                    onKeyDown="if(this.value.length==4 && event.keyCode!=8) return false;">
				</div>

                <div class="form-group">
                    <select class="form-control" id="semestre" name="semestre" required="required">
						<option value="">-Selecione o Semestre-</option>
                        <option value="1">1º Semestre</option>
                        <option value="2">2º Semestre</option>
                    </select>
				</div>

                <div class="form-group">
                    <select class="form-control" id="periodo" name="periodo" required="required">
						<option value="">-Selecione o Período-</option>
                        <option value="Matutino">Matutino</option>
                        <option value="Vespertino">Vespertino</option>
                        <option value="Noturno">Noturno</option>
                    </select>
				</div>

                <div class="form-group">
                    <select class="form-control" id="horario" name="horario" required="required">
						<option value="">-Selecione o Horário-</option>
                        <option value="08:00 às 12:00">08:00 às 12:00</option>
                        <option value="13:00 às 18:00">13:00 às 18:00</option>
                        <option value="19:15 às 22:00">19:15 às 22:00</option>
                    </select>
				</div>

				<div class="form-group">
					<input type="number" min="1" max="99" class="form-control" id="sala" name="sala" placeholder="*Sala"
                    required="required" onKeyDown="if(this.value.length==2 && event.keyCode!=8) return false;">
				</div>

				<input type="number" min="1" max="999" class="form-control" id="quantidadeAlunos"
                name="quantidadeAlunos" placeholder="*Quantidade de Alunos" required="required"
                onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;">

			</div>

			<div class="form-group">
				<input type="text" maxlength="2" class="form-control" id="turmas" name="turmas" placeholder="*Turmas. Ex.: 4A, 5B"
                style="text-transform:uppercase" inputonchange="this.value = this.value.toUpperCase()" required="required">
			</div>

            <div class="form-group">
                <select class="form-control" id="curso_idcurso" name="curso_idcurso" required="required" autofocus>
                    <option value="">-Selecione o Curso-</option>
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

			<button type="submit" class="btn btn-primary form-control">Cadastrar</button>
		</form>
	</div>
</div>
