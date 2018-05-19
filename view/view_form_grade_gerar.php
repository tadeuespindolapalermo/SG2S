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

    $selectMatrizSegunda = $matrizDao->listar($conn);
    $selectMatrizTerca = $matrizDao->listar($conn);
    $selectMatrizQuarta = $matrizDao->listar($conn);
    $selectMatrizQuinta = $matrizDao->listar($conn);
    $selectMatrizSexta = $matrizDao->listar($conn);
    $selectMatrizSabado = $matrizDao->listar($conn);
    $selectMatrizEad = $matrizDao->listar($conn);

    echo '

    <form action="';?><?php echo $url;?><?php echo '?pagina=view_grade_gerada.php&idGrade='.$grade->getIdGlobals().'" method="post">
        <h6 style="font-weight: 900">Disciplinas Semanais:</h6><br />
        <div class="form-row">
            <div style="width: 397px;  class="col">
                <select style="margin-bottom: 5px;" class="form-control" id="disciplinaSegunda" name="disciplinaSegunda" required>';
                    echo '<option value="">SEGUNDA-FEIRA - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">DIA EM ABERTO</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizSegunda->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaSegunda" name="salaSegunda" placeholder="*Sala"
                required>
            </div>&nbsp; &nbsp;

            <div style="width: 397px; class="col">
                <select class="form-control" id="disciplinaTerca" name="disciplinaTerca" required>';
                    echo '<option value="">TERÇA - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizTerca->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaTerca" name="salaTerca" placeholder="*Sala"
                required>
            </div>&nbsp;

            <div style="width: 397px; class="col">
                <select style="margin-bottom: 5px;" class="form-control" id="disciplinaQuarta" name="disciplinaQuarta" required>';
                    echo '<option value="">QUARTA-FEIRA - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizQuarta->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaQuarta" name="salaQuarta" placeholder="*Sala"
                required>
            </div>&nbsp; &nbsp;

            <div style="width: 397px; class="col">
                <select class="form-control" id="disciplinaQuinta" name="disciplinaQuinta" required>';
                    echo '<option value="">QUINTA-FEIRA - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizQuinta->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaQuinta" name="salaQuinta" placeholder="*Sala"
                required>
            </div>&nbsp;

            <div style="width: 397px; class="col">
                <select style="margin-bottom: 5px;" class="form-control" id="disciplinaSexta" name="disciplinaSexta" required>';
                    echo '<option value="">SEXTA-FEIRA - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizSexta->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaSexta" name="salaSexta" placeholder="*Sala"
                required>
            </div>&nbsp; &nbsp;

            <div style="width: 397px; class="col">
                <select class="form-control" id="disciplinaSabado" name="disciplinaSabado" required>';
                    echo '<option value="">SÁBADO - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizSabado->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaSabado" name="salaSabado" placeholder="*Sala"
                required>
            </div>&nbsp;

            <div style="width: 397px; class="col">
                <select class="form-control" id="disciplinaEad" name="disciplinaEad" required>';
                    echo '<option value="">EAD - Selecione:</option>';
                    echo '<option value="DIA EM ABERTO">*DIA EM ABERTO*</option>';
                    echo '<option value="">DEIXAR EM BRANCO</option>';
                    while ($linhaGradeCombo = $selectMatrizEad->fetchAll(PDO::FETCH_ASSOC)) {
                        foreach ($linhaGradeCombo as $dados) {
                            $matriz->setNomeMatriz($dados['nome_matriz']);
                            echo '<option value="'.$matriz->getNomeMatriz().'">'.$matriz->getNomeMatriz().'</option>';
                        }
                    }
                echo '
                </select>
            </div>&nbsp;

            <div style="width: 90px; class="col">
                <input type="number" min="1" max="99" class="form-control" id="salaEad" name="salaEad" placeholder="*Sala"
                required>
            </div>&nbsp;
        </div><br/>
        <div style="margin-left: -5px;">
            <button type="submit" class="btn btn-success">Enviar</button>
            <a href="';?><?php echo $url;?><?php echo '?pagina=view_grades_listagem.php" ><button type="button" class="btn btn-secondary">Voltar</button></a>
        </div>
    </form>'; ?>
