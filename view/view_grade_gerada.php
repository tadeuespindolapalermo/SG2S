<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Grade ID</h3><hr />
    </div>

    <?php
        session_start();

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $grade = new Grade();
        $gradeDao = new GradeDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectGrade = $gradeDao->buscarPorId($conn, 2);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaGradeGerada">
                            <thead>
                                <tr>
                                    <th>SEMESTRE</th>
                                    <th>TURMA</th>
                                    <th>Nª DE ALUNOS</th>
                                    <th>SEGUNDA</th>
                                    <th>TERÇA</th>
                                    <th>QUARTA</th>
                                    <th>QUINTA</th>
                                    <th>SEXTA</th>
                                    <th>SÁBADO</th>
                                    <th>EAD</th>
                                </tr>
                            </thead>
                            <?php
                                $grade->setSegunda($_POST['disciplinaSegunda']);
                                $grade->setTerca($_POST['disciplinaTerca']);
                                $grade->setQuarta($_POST['disciplinaQuarta']);
                                $grade->setQuinta($_POST['disciplinaQuinta']);
                                $grade->setSexta($_POST['disciplinaSexta']);
                                $grade->setSabado($_POST['disciplinaSabado']);
                                $grade->setEad($_POST['disciplinaEad']);

                                while ($linhaGrade = $selectGrade->fetchAll(PDO::FETCH_ASSOC)) {
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
                                        //$grade->setCursoNome($dados['nome']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <div style="text-align: center;"><h6>FACULDADE JK - SANTA MARIA</h6></div>
                                                <div style="text-align: center;"><h6>GRADE HORÁRIA: TECNÓLOGO EM '.$grade->getCursoNome().' - '.$grade->getSemestre().'º SEMESTRE DE '.$grade->getAnoLetivo().'</h6></div>
                                                <div style="text-align: center;"><h6>Período: '.$grade->getPeriodo().' - '.$grade->getHorario().'</h6></div>
                                                <td>'.$grade->getSemestre().'</td>
                                                <td>'.$grade->getTurmas().'</td>
                                                <td>'.$grade->getQuantidadeAlunos().'</td>
                                                <td>'.$grade->getSegunda().'</td>
                                                <td>'.$grade->getTerca().'</td>
                                                <td>'.$grade->getQuarta().'</td>
                                                <td>'.$grade->getQuinta().'</td>
                                                <td>'.$grade->getSexta().'</td>
                                                <td>'.$grade->getSabado().'</td>
                                                <td>'.$grade->getEad().'</td>';
                                                /*<td><a href="javascript:void(null);" onclick="msgConfirmaDeleteCurso('.$curso->getIdCurso().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_curso_update.php&idCurso='.$curso->getIdCurso().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>*/
                                                echo '
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <!--<a href="view_admin.php?pagina=view_form_curso_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaCursos" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
