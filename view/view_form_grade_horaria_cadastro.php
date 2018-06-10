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

	//Para listagem sem paginação
	$selectMatrizSeg = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizTer = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizQua = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizQui = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizSex = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizSab = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizEad1 = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());
	$selectMatrizEad2 = $gradeHorariaDao->listarMatriz($conn, $gradeHorariaCurso->getIdCursoGradeSemestral());

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

	<div>
		<br />
		<h3><strong><div style="margin-top: -50px; text-align: center;">Cadastrar Grade Horária</div></strong></h3><br/><br/><br/>
		<h3><strong><div style="margin-top: -60px; text-align: center;"><font color="blue"><?php echo $gradeHorariaCurso->getCursoNome();?></font></div></strong></h3><br/>

		<!-- VERIFICAR COM GEORGE A LÓGICA DE NEGÓCIO PARA REPETIÇÃO DE GRADE HORÁRIA-->
		<!--<small><strong>AVISO: 'Ano', 'Semestre' e 'Curso': trinca única!<strong></small><br/>-->

		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_horaria_cadastro.php" id="formGradeHoraria">

			<div class="form-row">
				<!--<div style="text-align: center;"><small><strong>*Campos Obrigatórios</strong></small></div>-->

				<?php echo '<br/>';?>
				<!--<small><strong>ID Grade Semestral</strong></small>-->

				<?php
				echo '
				<div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
					<div style="margin-left: -5px;"><small><strong>ID Grade Semestral</strong></small></div>
					<input style="width: 105px; margin-left: -5px;" type="text" class="form-control" id="idGradeSemestral" name="idGradeSemestral"
					placeholder="*ID da Grade Semestral" value="'.$gradeHorariaCurso->getIdGradeSemestral().'" disabled>
				</div>';?>

				<?php echo '
				<div class="col" style="padding: 5px; position:absolute; left:-9999px">
					<div style="margin-left: -5px;"><small><strong>ID Curso Grade Semestral</strong></small></div>
					<input style="width: 175px; margin-left: -5px;" type="text" class="form-control" id="idCursoGradeSemestral" name="idCursoGradeSemestral"
					placeholder="*Id do Curso da Grade Semestral" value="'.$gradeHorariaCurso->getIdCursoGradeSemestral().'" disabled>
				</div>';?>

				<div class="col">
					<input style="width: 320px;" type="number" min="0" max="8" class="form-control" id="periodoCurso" name="periodoCurso"
					placeholder="*Período Curso (Semestre) - de 1 a 8" required>
					<!-- Dependendo do curso:
                         Tecnólogo: 1 a 5
					 	 Licenciatura e bacharelado: 1 a 8.
						 Licenciatura grade antiga: 1 a 7.-->
				</div>

				<!--<div class="col">
					<input style="width: 320px;" type="number" min="0" max="99" class="form-control" id="sala" name="sala"
					placeholder="*Sala (Presencial) - Até 2 números" required autofocus>-->
					<!-- Local da aula presencial. -->
				<!--</div>-->

				<div class="col">
					<input style="width: 320px;" type="number" min="0" max="999" class="form-control" id="quantidadeAlunos" name="quantidadeAlunos"
					placeholder="*Quantidade Alunos - Até 3 números" required>
					<!-- Quantidade de alunos das turmas somados. -->
				</div>

				<div class="col">
					<input style="width: 312px;" type="text" maxlength="50" class="form-control" id="turmas" name="turmas"
					placeholder="*Turmas - Ex.: TADS (TADS2A)" required>
					<!-- PED - Pedagogia (PED6B)
						 LET - Letras (LET1A)
						 TADS (TADS2A)-->
				</div>
				<br/><br/><br/>


				<!--<div class="col" style="padding: 5px;">
					<input style="width: 320px;" type="number" min="1" max="7" class="form-control" id="diaSemana" name="diaSemana"
					placeholder="*Dia Semana - de 1 (Dom) a 7 (Sab)" required>-->
					<!-- Segunda a sábado:
						 - 1: Domingo
						 - 2: Segunda
						 - 3: Terça
						 - 4: Quarta
						 - 5: Quinta
						 - 6: Sexta
						 - 7: Sábado-->
				<!--</div>-->

				<!--<div class="col" style="padding: 5px;">
					<input style="width: 320px;" type="number" min="0" max="1" class="form-control" id="ead" name="ead"
					placeholder="*EAD: [ 0 ] Não - [ 1 ] Sim" required>-->
					<!-- 0 - Não é EAD
						 1 - EAD-->
				<!--</div>-->
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
			<?php
			echo '<br/>
		    <h6 style="font-weight: 900">Disciplinas Semanais:</h6>
			<div class="form-row">
				<div style="width: 505px;  class="col">
				   <select style="margin-bottom: 5px;" class="form-control" id="dsSeg" name="dsSeg" required>';
					   echo '<option value="">*Segunda-feira - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizSeg->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsSegProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSegProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSegProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select class="form-control" id="dsTer" name="dsTer" required>';
					   echo '<option value="">*Terça-feira - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizTer->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsTerProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsTerProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsTerProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select style="margin-bottom: 5px;" class="form-control" id="dsQua" name="dsQua" required>';
					   echo '<option value="">*Quarta-feira - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizQua->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsQuaProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsQuaProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsQuaProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select class="form-control" id="dsQui" name="dsQui" required>';
					   echo '<option value="">*Quinta-feira - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizQui->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsQuiProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsQuiProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsQuiProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select style="margin-bottom: 5px;" class="form-control" id="dsSex" name="dsSex" required>';
					   echo '<option value="">*Sexta-feira - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizSex->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsSexProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSexProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSexProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select class="form-control" id="dsSab" name="dsSab" required>';
					   echo '<option value="">*Sábado - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizSab->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsSabProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSabProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSabProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select class="form-control" id="dsEad1" name="dsEad1">';
					   echo '<option value="">EAD 1 - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizEad1->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsEad1Prof($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsEad1Prof().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsEad1Prof().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="width: 505px; class="col">
				   <select class="form-control" id="dsEad2" name="dsEad2">';
					   echo '<option value="">EAD 2 - Selecione:</option>';
					   echo '<option value="">Dia Livre</option>';
					   while ($linhaMatrizCombo = $selectMatrizEad2->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsEad2Prof($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong>Professor</strong>:<br/> '.$gradeHorariaCurso->getDsEad2Prof().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().'  - '.$gradeHorariaCurso->getDsEad2Prof().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    </div><br/>'; ?>
			<button type="submit" onclick="alterarDisabledCadastroGradeHoraria()" style="width: 250px; margin-left: -5px;" class="btn btn-outline-success form-control"><span data-feather="database"></span>&nbsp;Cadastrar</button>
			<a href="<?php echo $url;?>?pagina=view_grades_semestrais_listagem.php"><button style="width: 250px;" type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
        </form>
	</div>
</div>
