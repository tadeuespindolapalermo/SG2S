<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();
    $grade = new Grade();

    $matriz = new Matriz();
    $matrizDao = new MatrizDao();

    $idGrade = $_GET['idGrade'];

    $grade->setIdGlobals($GLOBALS['idGrade']);

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
        <h6 style="margin-left: 12px; font-weight: 900">Disciplinas da Semana:</h6><br />
        <form action="view_admin.php?pagina=view_grade_gerada.php&idGrade='.$grade->getIdGlobals().'" method="post">
            <div class="form-group">
                <div class="col-lg-12">

                <label class="col-lg-12 control-label label-especial"><strong>Segunda-feira<strong></label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaSegunda" name="salaSegunda" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">Terça-feira</label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaTerca" name="salaTerca" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">Quarta-feira</label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaQuarta" name="salaQuarta" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">Quinta-feira</label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaQuinta" name="salaQuinta" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">Sexta-feira</label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaSexta" name="salaSexta" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">Sábado</label>
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

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaSabado" name="salaSabado" placeholder="*Sala"
                    required>
				</div><br/>

                <label class="col-lg-12 control-label label-especial">EAD</label>
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
                </div><br/>

                <div class="form-group" style="width: 90px; margin-top: -10px;">
					<input type="number" min="1" max="99" class="form-control" id="salaEad" name="salaEad" placeholder="*Sala"
                    required>
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
