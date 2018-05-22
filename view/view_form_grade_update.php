<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();
    $grade = new Grade();

    $idGrade = $_GET['idGrade'];

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

    $selectGradeCombo = $gradeDao->listarCombo($conn);

    $selectGrade = $gradeDao->buscarPorId($conn, $idGrade);
    $linhaGrade = $selectGrade->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaGrade as $dados) {
        $grade->setIdGradeSemestral($dados['idgrade_semestral']);
        $grade->setAnoLetivo($dados['ano_letivo']);
        $grade->setSemestreLetivo($dados['semestre_letivo']);
        $grade->setTurno($dados['turno']);
        $grade->setHorario($dados['horario']);
        $grade->setCursoIdCurso($dados['curso_idcurso']);
        $grade->setCursoNome($dados['nome']);
    }
    $cursoNomeAuxiliar = $grade->getCursoNome();

    // VERIFICAÇÕES DO COMBO BOX SEMESTRE
    if ($grade->getSemestreLetivo() == 1) {
        $semestreLetivo = '1º Semestre';
        $semestreLetivoOption = '2º Semestre';
        $numSemestreLetivoOption = 2;
    } elseif ($grade->getSemestreLetivo() == 2) {
        $semestreLetivo = '2º Semestre';
        $semestreLetivoOption = '1º Semestre';
        $numSemestreLetivoOption = 1;
    }

    // VERIFICAÇÕES DO COMBO BOX PERIODO
    if ($grade->getTurno() == 'Matutino') {
        $turnoUmOption = 'Vespertino - 13:00 às 18:00';
        $valueTurnoUmOption = 'Vespertino';
        $turnoDoisOption = 'Noturno - 19:15 às 22:00';
        $valueTurnoDoisOption = 'Noturno';
        $turno = '08:00 às 12:00';
    } elseif ($grade->getTurno() == 'Vespertino') {
        $turnoUmOption = 'Matutino - 08:00 às 12:00';
        $valueTurnoUmOption = 'Matutino';
        $turnoDoisOption = 'Noturno - 19:15 às 22:00';
        $valueTurnoDoisOption = 'Noturno';
        $turno = '13:00 às 18:00';
    } elseif ($grade->getTurno() == 'Noturno') {
        $turnoUmOption = 'Vespertino - 13:00 às 18:00';
        $valueTurnoUmOption = 'Vespertino';
        $turnoDoisOption = 'Matutino - 08:00 às 12:00';
        $valueTurnoDoisOption = 'Matutino';
        $turno = '19:15 às 22:00';
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">Grade ID: '.strtoupper($grade->getIdGradeSemestral()).'</font><strong></h5></div><br />
            <form action="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_form_grade_update.php&idGrade='.$grade->getIdGradeSemestral().'" method="post">
                <div class="form-group ">

                    <small><strong>*Campos Obrigatórios</strong></small><br/><br/>

                    <label class="col-lg-12 control-label label-usuario">*Curso</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required autofocus>
                            <option value="'.$grade->getCursoIdCurso().'">'.$grade->getCursoNome().'</option>';
                            while ($linhaGradeCombo = $selectGradeCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaGradeCombo as $dados) {
                                    $grade->setCursoIdCurso($dados['idcurso']);
                                    $grade->setCursoNome($dados['nome']);
                                    if ($grade->getCursoNome($dados['nome']) === $cursoNomeAuxiliar) {
                                        $cursoCombo = '';
                                    } else {
                                        $cursoCombo = '<option value="'.$grade->getCursoIdCurso().'">'.$grade->getCursoNome().'</option>';
                                    }
                                    echo $cursoCombo;                                    
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Semestre_Letivo</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="semestreLetivo" name="semestreLetivo" required>
                            <option value="'.$grade->getSemestreLetivo().'">'.$semestreLetivo.'</option>
                            <option value="'.$numSemestreLetivoOption.'">'.$semestreLetivoOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Turno</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="turno" name="turno" required>
                            <option value="'.$grade->getTurno().'">'.$grade->getTurno().' - '.$turno.'</option>
                            <option value="'.$valueTurnoUmOption.'">'.$turnoUmOption.'</option>
                            <option value="'.$valueTurnoDoisOption.'">'.$turnoDoisOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Ano_Letivo</label>
                    <input type="number" min="2000" max="9999" style="width: 320px; margin-bottom: -5px;" required
                    id="anoLetivo" name="anoLetivo" class="form-control" value="'.$grade->getAnoLetivo().'"
                    placeholder="*Ano Letivo - Até 4 números"><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="';?><?php echo $url;?><?php echo '?pagina=view_grades_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
