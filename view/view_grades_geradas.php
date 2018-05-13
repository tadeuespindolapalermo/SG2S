<div class="container listar">

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

        $selectGradeGerada = $gradeGeradaDao->listar($conn);

        $selectGrade = $gradeDao->listar($conn);
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
            //$grade->setCursoNome($dados['nome']);
        }
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
                                echo '<br/>
                                <div style="text-align: center;"><h6><strong>FACULDADE JK - SANTA MARIA</strong></h6></div>
                                <div style="text-align: center;"><h6><strong>GRADE HORÁRIA: TECNÓLOGO EM '.$grade->getCursoNome().' - '.$grade->getSemestre().'º SEMESTRE DE '.$grade->getAnoLetivo().'</strong></h6></div>
                                <div style="text-align: center;"><h6><strong>Período: '.$grade->getPeriodo().' - '.$grade->getHorario().'</strong></h6></div><br/>';
                            ?>
                            <?php
                                while ($linhaGradeGerada = $selectGradeGerada->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaGradeGerada as $dados) {
                                        /*$grade->setIdGradeSemestral($dados['idgrade_semestral']);
                                        $grade->setAnoLetivo($dados['ano_letivo']);
                                        $grade->setSemestre($dados['semestre']);
                                        $grade->setPeriodo($dados['periodo']);
                                        $grade->setHorario($dados['horario']);
                                        $grade->setSala($dados['sala']);
                                        $grade->setQuantidadeAlunos($dados['quantidade_alunos']);
                                        $grade->setTurmas($dados['turmas']);
                                        $grade->setCursoIdCurso($dados['curso_idcurso']);*/
                                        //$grade->setCursoNome($dados['nome']);

                                        $gradeGerada->setDisciplinaSegunda($dados['disciplinaSEG']);
                                        $gradeGerada->setDisciplinaTerca($dados['disciplinaTER']);
                                        $gradeGerada->setDisciplinaQuarta($dados['disciplinaQUA']);
                                        $gradeGerada->setDisciplinaQuinta($dados['disciplinaQUI']);
                                        $gradeGerada->setDisciplinaSexta($dados['disciplinaSEX']);
                                        $gradeGerada->setDisciplinaSabado($dados['disciplinaSAB']);
                                        $gradeGerada->setDisciplinaEad($dados['disciplinaEAD']);

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$grade->getTurmas().'</td>
                                                <td>'.$grade->getQuantidadeAlunos().'</td>
                                                <td>'.$gradeGerada->getDisciplinaSegunda().'</td>
                                                <td>'.$gradeGerada->getDisciplinaTerca().'</td>
                                                <td>'.$gradeGerada->getDisciplinaQuarta().'</td>
                                                <td>'.$gradeGerada->getDisciplinaQuinta().'</td>
                                                <td>'.$gradeGerada->getDisciplinaSexta().'</td>
                                                <td>'.$gradeGerada->getDisciplinaSabado().'</td>
                                                <td>'.$gradeGerada->getDisciplinaEad().'</td>';
                                                /*<td><a href="javascript:void(null);" onclick="msgConfirmaDeleteCurso('.$curso->getIdCurso().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_curso_update.php&idCurso='.$curso->getIdCurso().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>*/

                                                echo '
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>

                        </table>
                        <a href="view_admin.php?pagina=view_grades_listagem.php"><button onclick="javascript:iniciaRequisitaAjax('GET','view_blank.html','true');" type="button" class="btn btn-secondary">Voltar</button></a>
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
