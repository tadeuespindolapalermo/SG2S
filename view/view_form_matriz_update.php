<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $matrizDao = new MatrizDao();
    $matriz = new Matriz();

    $idMatriz = $_GET['idMatriz'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectMatrizCombo = $matrizDao->listarCombo($conn);

    $selectMatriz = $matrizDao->buscarPorId($conn, $idMatriz);
    $linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhaMatriz as $dados) {
        $matriz->setIdMatrizCurricular($dados['idmatriz_curricular']);
        $matriz->setCursoIdCurso($dados['curso_idcurso']);
        $matriz->setCursoNome($dados['nome']);
        $matriz->setNomeMatriz($dados['nome_matriz']);
        $matriz->setCargaHoraria($dados['carga_horaria']);
        $matriz->setCredito($dados['credito']);
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">'.strtoupper($matriz->getNomeMatriz()).'.</font><strong></h5></div><br />
            <form action="view_admin.php?pagina=../controller/controller_form_matriz_update.php&idMatriz='.$matriz->getIdMatrizCurricular().'" method="post">
                <div class="form-group ">

                    <small><strong>*Campos Obrigatórios</strong></small><br/><br/>

                    <label class="col-lg-12 control-label label-usuario">*Curso</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="curso" name="curso" required="required" autofocus>
                            <option value="">-Selecione o Curso-</option>';
                            while ($linhaMatrizCombo = $selectMatrizCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaMatrizCombo as $dados) {
                                    $matriz->setCursoNome($dados['nome']);
                                    echo '<option value="'.$matriz->getCursoIdCurso().'">'.$matriz->getCursoNome().'</option>';
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Nome</label>
                    <input type="text" maxlength="100" style="width: 320px; margin-bottom: -5px;" id="nomeMatriz" name="nomeMatriz" class="form-control" placeholder="*Nome - Até 100 caracteres." value="'.$matriz->getNomeMatriz().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >*Carga_Horária</label>
                    <input type="number" min="1.00" max="999.99" style="width: 320px; margin-bottom: -5px;" id="cargaHoraria" name="cargaHoraria" class="form-control" placeholder="*Carga Horária - Entre 1.00 à 999.99" value="'.$matriz->getCargaHoraria().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Crédito</label>
                    <input type="number" min="0" max="9" style="width: 320px; margin-bottom: -5px;" id="credito" name="credito" class="form-control" placeholder="*Crédito - Entre 0 à 9" value="'.$matriz->getCredito().'" required><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="bbtn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="view_admin.php?pagina=view_matrizes_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
