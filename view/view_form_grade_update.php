<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();
    $grade = new Grade();

    $idGrade = $_GET['idGrade'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectGradeCombo = $gradeDao->listarCombo($conn);

    $selectGrade = $gradeDao->buscarPorId($conn, $idGrade);
    $linhaGrade = $selectGrade->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaGrade as $dados) {
        $grade->setIdGradeSemestral($dados['idgrade_semestral']);
        $grade->setAnoLetivo($dados['ano_letivo']);
        $grade->setSemestre($dados['semestre']);
        $grade->setPeriodo($dados['periodo']);
        $grade->setHorario($dados['horario']);
        $grade->setSala($dados['sala']);
        $grade->setQuantidadeAlunos($dados['quantidade_alunos']);
        $grade->setTurmas($dados['turmas']);
        $grade->setCursoIdCurso($dados['curso_idcurso']);
    }

    // VERIFICAÇÕES DO COMBO BOX SEMESTRE
    if ($grade->getSemestre() == 1) {
        $semestre = '1º Semestre';
        $semestreOption = '2º Semestre';
        $numSemestreOption = 2;
    } elseif ($grade->getSemestre() == 2) {
        $semestre = '2º Semestre';
        $semestreOption = '1º Semestre';
        $numSemestreOption = 1;
    }

    // VERIFICAÇÕES DO COMBO BOX PERIODO
    if ($grade->getPeriodo() == 'Matutino') {
        $periodoUmOption = 'Vespertino - 13:00 às 18:00';
        $valuePeriodoUmOption = 'Vespertino';
        $periodoDoisOption = 'Noturno - 19:15 às 22:00';
        $valuePeriodoDoisOption = 'Noturno';
        $periodo = '08:00 às 12:00';
    } elseif ($grade->getPeriodo() == 'Vespertino') {
        $periodoUmOption = 'Matutino - 08:00 às 12:00';
        $valuePeriodoUmOption = 'Matutino';
        $periodoDoisOption = 'Noturno - 19:15 às 22:00';
        $valuePeriodoDoisOption = 'Noturno';
        $periodo = '13:00 às 18:00';
    } elseif ($grade->getPeriodo() == 'Noturno') {
        $periodoUmOption = 'Vespertino - 13:00 às 18:00';
        $valuePeriodoUmOption = 'Vespertino';
        $periodoDoisOption = 'Matutino - 08:00 às 12:00';
        $valuePeriodoDoisOption = 'Matutino';
        $periodo = '19:15 às 22:00';
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">Grade ID: '.strtoupper($grade->getIdGradeSemestral()).'</font><strong></h5></div><br />
            <form action="view_admin.php?pagina=../controller/controller_form_grade_update.php&idGrade='.$grade->getIdGradeSemestral().'" method="post">
                <div class="form-group ">

                    <label class="col-lg-12 control-label label-usuario">Curso</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required autofocus>
                            <option value="">-Selecione o Curso-</option>';
                            while ($linhaGradeCombo = $selectGradeCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaGradeCombo as $dados) {
                                    $grade->setCursoIdCurso($dados['idcurso']);
                                    $grade->setCursoNome($dados['nome']);
                                    echo '<option value="'.$grade->getCursoIdCurso().'">'.$grade->getCursoNome().'</option>';
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Semestre</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="semestre" name="semestre" required>
                            <option value="'.$grade->getSemestre().'">'.$semestre.'</option>
                            <option value="'.$numSemestreOption.'">'.$semestreOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Período</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="periodo" name="periodo" required>
                            <option value="'.$grade->getPeriodo().'">'.$grade->getPeriodo().' - '.$periodo.'</option>
                            <option value="'.$valuePeriodoUmOption.'">'.$periodoUmOption.'</option>
                            <option value="'.$valuePeriodoDoisOption.'">'.$periodoDoisOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Ano_Letivo</label>
                    <input type="number" min="2000" max="9999" style="width: 320px; margin-bottom: -5px;" required
                    id="anoLetivo" name="anoLetivo" class="form-control" value="'.$grade->getAnoLetivo().'"
                    placeholder="*Ano Letivo - Até 4 números"><br/>

                    <label class="col-lg-2 control-label label-usuario" >Sala</label>
                    <input type="number" min="1" max="99" style="width: 320px; margin-bottom: -5px;" id="sala"
                    name="sala" class="form-control" value="'.$grade->getSala().'"
                    placeholder="*Sala - Entre 1 a 99" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Quantidade_Alunos</label>
                    <input type="number" min="1" max="999" style="width: 320px; margin-bottom: -5px;"
                    id="quantidadeAlunos" name="quantidadeAlunos" class="form-control" value="'.$grade->getQuantidadeAlunos().'"
                    placeholder="*Quantidade de Alunos - Entre 1 a 999" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Turmas</label>
                    <input type="text" maxlength="50" style="width: 320px; margin-bottom: -5px; text-transform:uppercase;"
                    id="turmas" name="turmas" class="form-control" value="'.$grade->getTurmas().'"
                    inputonchange="this.value = this.value.toUpperCase()" required placeholder="*SIST5A"><br/>

                    <button type="submit" class="btn btn-outline-primary form-control">Atualizar</button><br/><br/>
                </div>
            </form>
        </div>
    </div>';
