<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeSemestralDao = new GradeSemestralDao();
    $gradeSemestral = new GradeSemestral();

    $idGradeSemestral = $_GET['idGradeSemestral'];

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

    $selectGradeSemestralCombo = $gradeSemestralDao->listarCombo($conn);

    $selectGradeSemestral = $gradeSemestralDao->buscarPorId($conn, $idGradeSemestral);
    $linhaGradeSemestral = $selectGradeSemestral->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaGradeSemestral as $dados) {
        $gradeSemestral->setIdGradeSemestral($dados['idgrade_semestral']);
        $gradeSemestral->setAnoLetivo($dados['ano_letivo']);
        $gradeSemestral->setSemestreLetivo($dados['semestre_letivo']);
        $gradeSemestral->setTurno($dados['turno']);
        $gradeSemestral->setHorario($dados['horario']);
        $gradeSemestral->setCursoIdCurso($dados['curso_idcurso']);
        $gradeSemestral->setCursoNome($dados['nome']);
    }
    $cursoNomeAuxiliar = $gradeSemestral->getCursoNome();

    // VERIFICAÇÕES DO COMBO BOX SEMESTRE
    if ($gradeSemestral->getSemestreLetivo() == 1) {
        $semestreLetivo = '1º Semestre';
        $semestreLetivoOption = '2º Semestre';
        $numSemestreLetivoOption = 2;
    } elseif ($gradeSemestral->getSemestreLetivo() == 2) {
        $semestreLetivo = '2º Semestre';
        $semestreLetivoOption = '1º Semestre';
        $numSemestreLetivoOption = 1;
    }

    // VERIFICAÇÕES DO COMBO BOX PERIODO
    if ($gradeSemestral->getTurno() == 'Matutino') {
        $turnoUmOption = 'Vespertino - 13:00 às 18:00';
        $valueTurnoUmOption = 'Vespertino';
        $turnoDoisOption = 'Noturno - 19:15 às 22:00';
        $valueTurnoDoisOption = 'Noturno';
        $turno = '08:00 às 12:00';
    } elseif ($gradeSemestral->getTurno() == 'Vespertino') {
        $turnoUmOption = 'Matutino - 08:00 às 12:00';
        $valueTurnoUmOption = 'Matutino';
        $turnoDoisOption = 'Noturno - 19:15 às 22:00';
        $valueTurnoDoisOption = 'Noturno';
        $turno = '13:00 às 18:00';
    } elseif ($gradeSemestral->getTurno() == 'Noturno') {
        $turnoUmOption = 'Vespertino - 13:00 às 18:00';
        $valueTurnoUmOption = 'Vespertino';
        $turnoDoisOption = 'Matutino - 08:00 às 12:00';
        $valueTurnoDoisOption = 'Matutino';
        $turno = '19:15 às 22:00';
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <div style="text-align: center;"><h4><strong>Atualizar Grade Semestral</strong></h4></div>';
            ?><!--<div style="text-align: center;"><h5><strong><font color="#FF0000">Grade ID: '.strtoupper($gradeSemestral->getIdGradeSemestral()).'</font><strong></h5></div>--><?php
            echo '
            <form action="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_form_grade_semestral_update.php&idGradeSemestral='.$gradeSemestral->getIdGradeSemestral().'" method="post">
                <div class="form-group ">

                    <div style="text-align: center;"><small><strong>*Campos Obrigatórios</strong></small></div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Curso</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required autofocus>
                            <option value="'.$gradeSemestral->getCursoIdCurso().'">'.$gradeSemestral->getCursoNome().'</option>';
                            while ($linhaGradeSemestralCombo = $selectGradeSemestralCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaGradeSemestralCombo as $dados) {
                                    $gradeSemestral->setCursoIdCurso($dados['idcurso']);
                                    $gradeSemestral->setCursoNome($dados['nome']);
                                    if ($gradeSemestral->getCursoNome($dados['nome']) === $cursoNomeAuxiliar) {
                                        $cursoCombo = '';
                                    } else {
                                        $cursoCombo = '<option value="'.$gradeSemestral->getCursoIdCurso().'">'.$gradeSemestral->getCursoNome().'</option>';
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
                            <option value="'.$gradeSemestral->getSemestreLetivo().'">'.$semestreLetivo.'</option>
                            <option value="'.$numSemestreLetivoOption.'">'.$semestreLetivoOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Turno</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="turno" name="turno" required>
                            <option value="'.$gradeSemestral->getTurno().'">'.$gradeSemestral->getTurno().' - '.$turno.'</option>
                            <option value="'.$valueTurnoUmOption.'">'.$turnoUmOption.'</option>
                            <option value="'.$valueTurnoDoisOption.'">'.$turnoDoisOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Ano_Letivo</label>
                    <input type="number" min="2000" max="9999" style="width: 320px; margin-bottom: -5px;" required
                    id="anoLetivo" name="anoLetivo" class="form-control" value="'.$gradeSemestral->getAnoLetivo().'"
                    placeholder="*Ano Letivo - Até 4 números"><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
