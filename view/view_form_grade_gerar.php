<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();
    $grade = new Grade();

    $matriz = new Matriz();
    $matrizDao = new MatrizDao();

    $idGrade = $_GET['idGrade'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectMatrizSegunda = $matrizDao->listar($conn);
    $selectMatrizTerca = $matrizDao->listar($conn);
    $selectMatrizQuarta = $matrizDao->listar($conn);
    $selectMatrizQuinta = $matrizDao->listar($conn);
    $selectMatrizSexta = $matrizDao->listar($conn);
    $selectMatrizSabado = $matrizDao->listar($conn);
    $selectMatrizEad = $matrizDao->listar($conn);

    echo '
    <div class="container" style="margin-left: -25px;">
        <h5 style="margin-left: 12px;">Selecione as Disciplinas da Semana:</h5><br />
        <form action="view_admin.php?pagina=view_grade_gerada.php&idGrade='.$GLOBALS['idGrade'].'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                <label class="col-lg-12 control-label label-usuario">Segunda</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaSegunda" name="disciplinaSegunda" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizSegunda->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">Terça</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaTerca" name="disciplinaTerca" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizTerca->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">Quarta</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaQuarta" name="disciplinaQuarta" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizQuarta->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">Quinta</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaQuinta" name="disciplinaQuinta" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizQuinta->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">Sexta</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaSexta" name="disciplinaSexta" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizSexta->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">Sábado</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaSabado" name="disciplinaSabado" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizSabado->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>

                <label class="col-lg-12 control-label label-usuario">EAD</label>
                <div class="form-group" style="width: 397px; margin-bottom: -5px;">
                    <select class="form-control" id="disciplinaEad" name="disciplinaEad" required>';
                        echo '<option value="">-Selecione a Disciplina-</option>';
                        echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                        while ($linhaGradeCombo = $selectMatrizEad->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $matriz->setNomeMatriz($dados['nome_matriz']);
                                echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>';
                ?>

                <button type="submit" class="btn btn-success">Enviar</button>
                <a href="view_admin.php?pagina=view_grades_listagem.php" ><button type="button" class="btn btn-secondary">Voltar</button></a>
                <?php
                echo '
                </div>
            </div>
        </form>
    </div>';
