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

    $selectMatriz = $matrizDao->buscarPorId($conn, $idMatriz);
    $linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaMatriz as $dados) {
        $matriz->setCursoIdCurso($dados['curso_idcurso']);
        $matriz->setNomeMatriz($dados['nome_matriz']);
        $matriz->setCargaHoraria($dados['carga_horaria']);
        $matriz->setCredito($dados['credito']);
    }

    $selectMatrizCombo = $matrizDao->listarCombo($conn);

    echo '
    <div class="container">
        <h4>Atualizar Matriz (Disciplina)</h4><br />
        <form action="view_admin.php?pagina=../controller/controller_form_matriz_update.php&idMatriz='.$matriz->getIdMatrizCurricular().'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Curso</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="curso_idcurso" name="curso_idcurso" required="required" autofocus>
                            <option style="font-weight: 900" value="'.$matriz->getCursoIdCurso().'">'.$matriz->getCursoIdCurso().'</option>
                            <option></option>';
                            while ($linhaMatriz = $selectMatrizCombo->fetchAll(PDO::FETCH_ASSOC)) {
                                foreach ($linhaMatriz as $dados) {
                                    $matriz->setCursoIdCurso($dados['idcurso']);
                                    $matriz->setCursoNome($dados['nome']);
                                    echo '<option style="font-weight: 900">'.$matriz->getCursoIdCurso().'</option>';
                                    echo '<option disabled>'.$matriz->getCursoNome().' ('.$matriz->getCursoIdCurso().')'.'</option>';
                                }
                            }
                            echo '
                        </select>
                    </div><br/>

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nomeMatriz" name="nomeMatriz" class="form-control" value="'.$matriz->getNomeMatriz().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Carga_Horária</label>
                    <input type="number" min="0" max="999.99" style="width: 300px; margin-bottom: -5px;" id="cargaHoraria" name="cargaHoraria" class="form-control" value="'.$matriz->getCargaHoraria().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Crédito</label>
                    <input type="number" min="0" max="9" style="width: 300px; margin-bottom: -5px;" id="credito" name="credito" class="form-control" value="'.$matriz->getCredito().'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
