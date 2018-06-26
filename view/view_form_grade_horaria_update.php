<!--<div class="container">
    <h1><strong>ATUALIZAÇÃO DE GRADES HORÁRIAS EM CONSTRUÇÃO...</strong></h1>
</div>--><?php // exit(); ?>

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

    $idGradeHoraria = $_GET['idGradeHoraria'];
    //$gradeHoraria->setIdGradeHoraria($idGradeHoraria);

    $idGradeSemestral = $_GET['idGradeSemestral'];
    //$gradeHoraria->setIdGradeSemestral($idGradeSemestral);

    /*$idGrHor = $gradeHorariaDao->listarIdGradeSemestral($conn, $idGradeHoraria);
    $linhaIdGrHor = $idGrHor->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaIdGrHor as $dados) {
        $idGradeSemestral = $dados['grade_semestral_idgrade_semestral'];
    }*/


    $gradeHorariaCurso->setIdGradeSemestral($idGradeSemestral);
    $gradeHoraria->setIdGradeHoraria($idGradeHoraria);



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

    // UPDATE
    $selectGradeHorariaUpdate = $gradeHorariaDao->buscarGradeHorariaPorId($conn, $idGradeHoraria);
    $linhaGradeHorariaUpdate = $selectGradeHorariaUpdate->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaGradeHorariaUpdate as $dados) {
        $gradeHoraria->setIdGradeHoraria($dados['idgrade_horaria']);
        $gradeHoraria->setQuantidadeAlunos($dados['quantidade_alunos']);
        $gradeHoraria->setTurmas($dados['turmas']);
        $gradeHoraria->setPeriodoCurso($dados['periodo_curso']);
        $gradeHoraria->setIdGradeSemestral($dados['grade_semestral_idgrade_semestral']);
        $gradeHoraria->setIdCursoGradeSemestral($dados['grade_semestral_curso_idcurso']);
        $gradeHoraria->setDsSeg($dados['dsSeg']);
        $gradeHoraria->setDsTer($dados['dsTer']);
        $gradeHoraria->setDsQua($dados['dsQua']);
        $gradeHoraria->setDsQui($dados['dsQui']);
        $gradeHoraria->setDsSex($dados['dsSex']);
        $gradeHoraria->setDsSab($dados['dsSab']);
        $gradeHoraria->setDsEad1($dados['dsEad1']);
        $gradeHoraria->setDsEad2($dados['dsEad2']);
        $gradeHoraria->setDsSegSala($dados['dsSegSala']);
        $gradeHoraria->setDsTerSala($dados['dsTerSala']);
        $gradeHoraria->setDsQuaSala($dados['dsQuaSala']);
        $gradeHoraria->setDsQuiSala($dados['dsQuiSala']);
        $gradeHoraria->setDsSexSala($dados['dsSexSala']);
        $gradeHoraria->setDsSabSala($dados['dsSabSala']);
    }

	$selectGradeHoraria = $gradeHorariaDao->buscarPorId($conn, $gradeHoraria->getIdCursoGradeSemestral());
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
?>

<div class="container">

	<br /><br />

	<div>
		<br />
		<h3><strong><div style="margin-top: -50px; text-align: center;">Atualizar Grade Horária</div></strong></h3><br/><br/><br/>
		<h3><strong><div style="margin-top: -60px; text-align: center;"><font color="blue"><?php echo $gradeHorariaCurso->getCursoNome();?></font></div></strong></h3><br/>

		<!-- VERIFICAR COM GEORGE A LÓGICA DE NEGÓCIO PARA REPETIÇÃO DE GRADE HORÁRIA-->
		<!--<small><strong>AVISO: 'Ano', 'Semestre' e 'Curso': trinca única!<strong></small><br/>-->

		<form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_grade_horaria_update.php" id="formGradeHoraria">

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

                <?php
                echo '
                <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                    <div style="margin-left: -5px;"><small><strong>ID Grade Horária</strong></small></div>
                    <input style="width: 105px; margin-left: -5px;" type="text" class="form-control" id="idGradeHoraria" name="idGradeHoraria"
                    placeholder="*ID da Grade Horária" value="'.$gradeHoraria->getIdGradeHoraria().'">
                </div>';?>

				<?php echo '
				<div class="col" style="padding: 5px; position:absolute; left:-9999px">
					<div style="margin-left: -5px;"><small><strong>ID Curso Grade Semestral</strong></small></div>
					<input style="width: 175px; margin-left: -5px;" type="text" class="form-control" id="idCursoGradeSemestral" name="idCursoGradeSemestral"
					placeholder="*Id do Curso da Grade Semestral" value="'.$gradeHorariaCurso->getIdCursoGradeSemestral().'" disabled>
				</div>';?>

				<div class="col">
                    <label><strong>Período do Curso</strong></label>
					<input style="width: 320px;" type="number" min="0" max="8" class="form-control" id="periodoCurso" name="periodoCurso"
					placeholder="*Período Curso (Semestre) - de 1 a 8" value="<?php echo $gradeHoraria->getPeriodoCurso(); ?>" required>
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
                    <label><strong>Quantidade de Alunos</strong></label>
					<input style="width: 320px;" type="number" min="0" max="999" class="form-control" id="quantidadeAlunos" name="quantidadeAlunos"
					placeholder="*Quantidade Alunos - Até 3 números" value="<?php echo $gradeHoraria->getQuantidadeAlunos(); ?>" required>
					<!-- Quantidade de alunos das turmas somados. -->
				</div>

				<div class="col">
                    <label><strong>Turmas</strong></label>
					<input style="width: 308px;" type="text" maxlength="50" class="form-control" id="turmas" name="turmas"
					placeholder="*Turmas - Ex.: TADS (TADS2A)" value="<?php echo $gradeHoraria->getTurmas(); ?>" required>
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
		    <h6 style="font-weight: 900">Disciplinas Semanais:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sala:
			</h6>
			<div class="form-row">
				<div style="width: 400px;  class="col">
                <small>Segunda-feira</small>
				   <select style="margin-bottom: 5px;" class="form-control" id="dsSeg" name="dsSeg">';
					   echo '<option value="'.$gradeHoraria->getDsSeg().'">'.$gradeHoraria->getDsSeg().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizSeg->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsSegProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSegProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSegProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                    <small>Seg</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaSeg" name="salaSeg" placeholder="Seg" value="'.$gradeHoraria->getDsSegSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 405px; class="col">
                    <small>Terça-feira</small>
				   <select class="form-control" id="dsTer" name="dsTer">';
					   echo '<option value="'.$gradeHoraria->getDsTer().'">'.$gradeHoraria->getDsTer().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizTer->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsTerProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsTerProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsTerProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                <small>Ter</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaTer" name="salaTer" placeholder="Ter" value="'.$gradeHoraria->getDsTerSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 400px; class="col">
                    <small>Quarta-feira</small>
				   <select style="margin-bottom: 5px;" class="form-control" id="dsQua" name="dsQua">';
					   echo '<option value="'.$gradeHoraria->getDsQua().'">'.$gradeHoraria->getDsQua().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizQua->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsQuaProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsQuaProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsQuaProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                <small>Qua</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaQua" name="salaQua" placeholder="Qua" value="'.$gradeHoraria->getDsQuaSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 405px; class="col">
                <small>Quinta-feira</small>
				   <select class="form-control" id="dsQui" name="dsQui">';
					   echo '<option value="'.$gradeHoraria->getDsQui().'">'.$gradeHoraria->getDsQui().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizQui->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsQuiProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsQuiProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsQuiProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                <small>Qui</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaQui" name="salaQui" placeholder="Qui" value="'.$gradeHoraria->getDsQuiSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 400px; class="col">
                <small>Sexta-feira</small>
				   <select style="margin-bottom: 5px;" class="form-control" id="dsSex" name="dsSex">';
					   echo '<option value="'.$gradeHoraria->getDsSex().'">'.$gradeHoraria->getDsSex().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizSex->fetchAll(PDO::FETCH_ASSOC)) {
						   foreach ($linhaMatrizCombo as $dados) {
							   $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
							   $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							   $gradeHorariaCurso->setDsSexProf($dados['nome']);
							   echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSexProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSexProf().'</option>';
						   }
					   }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                <small>Sex</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaSex" name="salaSex" placeholder="Sex" value="'.$gradeHoraria->getDsSexSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 405px; class="col">
                    <small>Sábado</small>
				   <select class="form-control" id="dsSab" name="dsSab">';
					   echo '<option value="'.$gradeHoraria->getDsSab().'">'.$gradeHoraria->getDsSab().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizSab->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsSabProf($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsSabProf().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsSabProf().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -5px; width: 90px; class="col">
                    <small>Sab</small>
				    <input type="number" min="1" max="99" class="form-control" id="salaSab" name="salaSab" placeholder="Sab" value="'.$gradeHoraria->getDsSabSala().'">
		        </div>&nbsp; &nbsp;

				<div style="width: 505px; class="col">
                    <small>Ead1</small>
				   <select class="form-control" id="dsEad1" name="dsEad1">';
					   echo '<option value="'.$gradeHoraria->getDsEad1().'">'.$gradeHoraria->getDsEad1().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizEad1->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsEad1Prof($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsEad1Prof().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().' - '.$gradeHorariaCurso->getDsEad1Prof().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<div style="margin-left: -7px; width: 508px; class="col">
                    <small>Ead2</small>
				   <select class="form-control" id="dsEad2" name="dsEad2">';
					   echo '<option value="'.$gradeHoraria->getDsEad2().'">'.$gradeHoraria->getDsEad2().'</option>';
					   echo '<option value="">Folga</option>';
					   while ($linhaMatrizCombo = $selectMatrizEad2->fetchAll(PDO::FETCH_ASSOC)) {
 						  foreach ($linhaMatrizCombo as $dados) {
 							  $gradeHorariaCurso->setDisciplinaNome($dados['nome_disciplina']);
 							  $gradeHorariaCurso->setDisciplinaId($dados['iddisciplinas']);
							  $gradeHorariaCurso->setDsEad2Prof($dados['nome']);
 							  echo '<option value="'.$gradeHorariaCurso->getDisciplinaNome().'<br/><small><strong> - Professor</strong>:<br/> '.$gradeHorariaCurso->getDsEad2Prof().'</small>">'.$gradeHorariaCurso->getDisciplinaNome().'  - '.$gradeHorariaCurso->getDsEad2Prof().'</option>';
 						  }
 					  }
				   echo '
				   </select>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		    </div><br/>'; ?>
			<button type="submit" onclick="alterarDisabledCadastroGradeHoraria()" style="width: 250px; margin-left: -5px;" class="btn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
			<a href="<?php echo $url;?>?pagina=view_form_grade_semestral_selecionar.php"><button style="width: 250px;" type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
        </form>
	</div>
</div>
