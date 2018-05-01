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
        $periodoUmOption = 'Vespertino';
        $periodoDoisOption = 'Noturno';
    } elseif ($grade->getPeriodo() == 'Vespertino') {
        $periodoUmOption = 'Matutino';
        $periodoDoisOption = 'Noturno';
    } elseif ($grade->getPeriodo() == 'Noturno') {
        $periodoUmOption = 'Vespertino';
        $periodoDoisOption = 'Matutino';
    }

    // VERIFICAÇÕES DO COMBO BOX HORARIO
    if ($grade->getHorario() == '08:00 às 12:00') {
        $horarioUmOption = '19:15 às 22:00';
        $horarioDoisOption = '13:00 às 18:00';
    } elseif ($grade->getHorario() == '19:15 às 22:00') {
        $horarioUmOption = '08:00 às 12:00';
        $horarioDoisOption = '13:00 às 18:00';
    } elseif ($grade->getHorario() == '13:00 às 18:00') {
        $horarioUmOption = '08:00 às 12:00';
        $horarioDoisOption = '19:15 às 22:00';
    }

    echo '
    <div class="container">
        <h4>Atualizar Grade</h4><br />
        <form action="view_admin.php?pagina=../controller/controller_form_grade_update.php&idGrade='.$grade->getIdGradeSemestral().'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Ano_Letivo</label>
                    <input type="number" min="2000" max="9999" style="width: 300px; margin-bottom: -5px;"
                    id="anoLetivo" name="anoLetivo" class="form-control" value="'.$grade->getAnoLetivo().'"
                    onKeyDown="if(this.value.length==4 && event.keyCode!=8) return false;" autofocus required><br/>

                    <label class="col-lg-12 control-label label-usuario">Semestre</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="semestre" name="semestre" required="required">
                            <option value="'.$grade->getSemestre().'">'.$semestre.'</option>
                            <option value="'.$numSemestreOption.'">'.$semestreOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Período</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="periodo" name="periodo" required="required">
                            <option value="'.$grade->getPeriodo().'">'.$grade->getPeriodo().'</option>
                            <option value="'.$periodoUmOption.'">'.$periodoUmOption.'</option>
                            <option value="'.$periodoDoisOption.'">'.$periodoDoisOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Horário</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="horario" name="horario" required="required">
                            <option value="'.$grade->getHorario().'">'.$grade->getHorario().'</option>
                            <option value="'.$horarioUmOption.'">'.$horarioUmOption.'</option>
                            <option value="'.$horarioDoisOption.'">'.$horarioDoisOption.'</option>
                        </select>
                    </div><br/>

                    <label class="col-lg-2 control-label label-usuario" >Sala</label>
                    <input type="number" min="1" max="99" style="width: 300px; margin-bottom: -5px;" id="sala"
                    name="sala" class="form-control" value="'.$grade->getSala().'"
                    onKeyDown="if(this.value.length==2 && event.keyCode!=8) return false;" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Quantidade_Alunos</label>
                    <input type="number" min="1" max="999" style="width: 300px; margin-bottom: -5px;"
                    id="quantidadeAlunos" name="quantidadeAlunos" class="form-control" value="'.$grade->getQuantidadeAlunos().'"
                    onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Turmas</label>
                    <input type="text" maxlength="2" style="width: 300px; margin-bottom: -5px; text-transform:uppercase;"
                    id="turmas" name="turmas" class="form-control" value="'.$grade->getTurmas().'"
                    inputonchange="this.value = this.value.toUpperCase()" required><br/>

                    <label class="col-lg-12 control-label label-usuario">Curso</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required="required">
                            <option value="'.$grade->getCursoIdCurso().'">('.$grade->getCursoIdCurso().')</option>';
                            while ($linhaGradeCombo = $selectGradeCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaGradeCombo as $dados) {
                                    $grade->setCursoIdCurso($dados['idcurso']);
                                    $grade->setCursoNome($dados['nome']);
                                    echo '<option value="'.$grade->getCursoIdCurso().'">'.$grade->getCursoNome().' ('.$grade->getCursoIdCurso().')'.'</option>';
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
