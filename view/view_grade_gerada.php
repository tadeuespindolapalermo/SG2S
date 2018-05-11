<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Grade ID</h3><hr />
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $grade = new Grade();
        $gradeDao = new GradeDao();

        $gradeGerada = new GradeGerada();
        $gradeGeradaDao = new GradeGeradaDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }
        $grade->setIdGlobals($_GET['idGrade']);
        $id = $grade->getIdGlobals();
        $selectGrade = $gradeDao->buscarPorId($conn, $id);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaGradeGerada">
                            <thead>
                                <tr>
                                    <th>SEMESTRE / TURMA</th>
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
                                $gradeGerada->setDisciplinaSegunda($_POST['disciplinaSegunda']);
                                $gradeGerada->setDisciplinaTerca($_POST['disciplinaTerca']);
                                $gradeGerada->setDisciplinaQuarta($_POST['disciplinaQuarta']);
                                $gradeGerada->setDisciplinaQuinta($_POST['disciplinaQuinta']);
                                $gradeGerada->setDisciplinaSexta($_POST['disciplinaSexta']);
                                $gradeGerada->setDisciplinaSabado($_POST['disciplinaSabado']);
                                $gradeGerada->setDisciplinaEad($_POST['disciplinaEad']);
                                $gradeGerada->setSalaSegunda($_POST['salaSegunda']);
                                $gradeGerada->setSalaTerca($_POST['salaTerca']);
                                $gradeGerada->setSalaQuarta($_POST['salaQuarta']);
                                $gradeGerada->setSalaQuinta($_POST['salaQuinta']);
                                $gradeGerada->setSalaSexta($_POST['salaSexta']);
                                $gradeGerada->setSalaSabado($_POST['salaSabado']);
                                $gradeGerada->setSalaEad($_POST['salaEad']);

                                // Inserção da Grade Gerada no Banco
                                $cadastroGradeGeradaEfetuado = $gradeGeradaDao->inserir($conn, $gradeGerada);

                                // VALIDAÇÃO DA INSERÇÃO DA GRADE GERADA
                                if($cadastroGradeGeradaEfetuado) {
                                    echo "
                                    <script type=\"text/javascript\">
                                        alert(\"Grade gerada com sucesso!\");
                                    </script>"; /*echo "
                                    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                                    http://localhost/SG2S/view/view_admin.php?pagina=view_grade_gerada.php'";*/
                                    //header('Location: ../view/view_admin.php?pagina=view_grade_gerada.php');
                                } else {
                                    echo "
                                    <script type=\"text/javascript\">
                                        alert(\"Erro ao gerar a grade!!!\");
                                    </script>
                                    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                                    http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_gerar.php'";
                                    //header('Location: ../view/view_admin.php?pagina=view_form_grade_gerar.php');
                                }

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
                                        $grade->setCursoNome($dados['nome']);
                                        $grade->setCursoGrau($dados['grau']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <br/>
                                                <div style="text-align: center;"><h6><strong>FACULDADE JK - SANTA MARIA</strong></h6></div>
                                                <div style="text-align: center;"><h6><strong>GRADE HORÁRIA: '.$grade->getCursoGrau().' em '.$grade->getCursoNome().' - '.$grade->getSemestre().'º SEMESTRE DE '.$grade->getAnoLetivo().'</strong></h6></div>
                                                <div style="text-align: center;"><h6><strong>Período: '.$grade->getPeriodo().' - '.$grade->getHorario().'</strong></h6></div><br/>
                                                <td>'.$grade->getTurmas().'</td>
                                                <td>'.$grade->getQuantidadeAlunos().'</td>
                                                <td>'.$gradeGerada->getDisciplinaSegunda().'<hr>Sala: '.$gradeGerada->getSalaSegunda().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaTerca().'<hr>Sala: '.$gradeGerada->getSalaTerca().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaQuarta().'<hr>Sala: '.$gradeGerada->getSalaQuarta().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaQuinta().'<hr>Sala: '.$gradeGerada->getSalaQuinta().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaSexta().'<hr>Sala: '.$gradeGerada->getSalaSexta().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaSabado().'<hr>Sala: '.$gradeGerada->getSalaSabado().'<hr>Professor</td>
                                                <td>'.$gradeGerada->getDisciplinaEad().'<hr>Sala: '.$gradeGerada->getSalaEad().'<hr>Professor</td>';
                                                /*<td><a href="javascript:void(null);" onclick="msgConfirmaDeleteCurso('.$curso->getIdCurso().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_curso_update.php&idCurso='.$curso->getIdCurso().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>*/

                                                echo '
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>

                        </table>
                        <a href="view_admin.php?pagina=view_grades_geradas.php"><button class="btn btn-secondary"><span data-feather="list"></span>&nbsp;Listar Todas</button></a>
                        <a href="view_admin.php?pagina=view_grades_listagem.php"><button type="button" class="btn btn-dark">Voltar</button></a>
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
