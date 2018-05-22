<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $disciplinaDao = new DisciplinaDao();
    $disciplina = new Disciplina();

    $idDisciplina = $_GET['idDisciplina'];

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

    $selectDisciplinaCombo = $disciplinaDao->listarCombo($conn);

    $selectDisciplina = $disciplinaDao->buscarPorId($conn, $idDisciplina);
    $linhaDisciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaDisciplina as $dados) {
        $disciplina->setIdDisciplina($dados['iddisciplinas']);
        $disciplina->setCursoIdCurso($dados['curso_idcurso']);
        $disciplina->setCursoNome($dados['nome']);
        $disciplina->setNomeDisciplina($dados['nome_disciplina']);
        $disciplina->setCargaHoraria($dados['carga_horaria']);
        $disciplina->setCredito($dados['credito']);
    }
    $cursoNomeAuxiliar = $disciplina->getCursoNome();
    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">'.strtoupper($disciplina->getNomeDisciplina()).'.</font><strong></h5></div><br />
            <form action="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_form_disciplina_update.php&idDisciplina='.$disciplina->getIdDisciplina().'" method="post">
                <div class="form-group ">

                    <small><strong>*Campos Obrigatórios</strong></small><br/><br/>

                    <label class="col-lg-12 control-label label-usuario">*Curso</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required="required" autofocus>
                            <option value="'.$disciplina->getCursoIdCurso().'">'.$disciplina->getCursoNome().'</option>';
                            while ($linhaDisciplinaCombo = $selectDisciplinaCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaDisciplinaCombo as $dados) {
                                    $disciplina->setCursoNome($dados['nome']);
                                    $disciplina->setCursoIdCurso($dados['idcurso']);
                                    if ($disciplina->getCursoNome($dados['nome']) === $cursoNomeAuxiliar) {
                                        $cursoCombo = '';
                                    } else {
                                        $cursoCombo = '<option value="'.$disciplina->getCursoIdCurso().'">'.$disciplina->getCursoNome().'</option>';
                                    }
                                    echo $cursoCombo;
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Nome</label>
                    <input type="text" maxlength="100" style="width: 320px; margin-bottom: -5px;" id="nomeDisciplina" name="nomeDisciplina" class="form-control" placeholder="*Nome - Até 100 caracteres." value="'.$disciplina->getNomeDisciplina().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >*Carga_Horária</label>
                    <input type="number" min="1.00" max="999.99" style="width: 320px; margin-bottom: -5px;" id="cargaHoraria" name="cargaHoraria" class="form-control" placeholder="*Carga Horária - Entre 1.00 à 999.99" value="'.$disciplina->getCargaHoraria().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Crédito</label>
                    <input type="number" min="0" max="9" style="width: 320px; margin-bottom: -5px;" id="credito" name="credito" class="form-control" placeholder="*Crédito - Entre 0 à 9" value="'.$disciplina->getCredito().'" required><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="bbtn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
