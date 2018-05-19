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
            $grade->setCursoNome($dados['nome']);
            $grade->setCursoGrau($dados['grau']);
        }

        $selectProfessor = $gradeGeradaDao->listarProfessor($conn);
        $linhaProfessor = $selectProfessor->fetchAll(PDO::FETCH_ASSOC);
        foreach ($linhaProfessor as $dados) {
            $professor = $dados['professor_idprofessor'];
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
                                <div style="text-align: center;"><h6><strong>GRADE HORÁRIA: '.$grade->getCursoGrau().' em '.$grade->getCursoNome().' - '.$grade->getSemestre().'º SEMESTRE DE '.$grade->getAnoLetivo().'</strong></h6></div>
                                <div style="text-align: center;"><h6><strong>Período: '.$grade->getPeriodo().' - '.$grade->getHorario().'</strong></h6></div><br/>';
                            ?>
                            <?php
                                while ($linhaGradeGerada = $selectGradeGerada->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaGradeGerada as $dados) {
                                        $gradeGerada->setDisciplinaSegunda($dados['disciplinaSEG']);
                                        $gradeGerada->setDisciplinaTerca($dados['disciplinaTER']);
                                        $gradeGerada->setDisciplinaQuarta($dados['disciplinaQUA']);
                                        $gradeGerada->setDisciplinaQuinta($dados['disciplinaQUI']);
                                        $gradeGerada->setDisciplinaSexta($dados['disciplinaSEX']);
                                        $gradeGerada->setDisciplinaSabado($dados['disciplinaSAB']);
                                        $gradeGerada->setDisciplinaEad($dados['disciplinaEAD']);
                                        $gradeGerada->setSalaSegunda($dados['salaSEG']);
                                        $gradeGerada->setSalaTerca($dados['salaTER']);
                                        $gradeGerada->setSalaQuarta($dados['salaQUA']);
                                        $gradeGerada->setSalaQuinta($dados['salaQUI']);
                                        $gradeGerada->setSalaSexta($dados['salaSEX']);
                                        $gradeGerada->setSalaSabado($dados['salaSAB']);
                                        $gradeGerada->setSalaEad($dados['salaEAD']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$grade->getTurmas().'</td>
                                                <td>'.$grade->getQuantidadeAlunos().'</td>
                                                <td>'.$gradeGerada->getDisciplinaSegunda().'<hr>Sala: '.$gradeGerada->getSalaSegunda().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaTerca().'<hr>Sala: '.$gradeGerada->getSalaTerca().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaQuarta().'<hr>Sala: '.$gradeGerada->getSalaQuarta().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaQuinta().'<hr>Sala: '.$gradeGerada->getSalaQuinta().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaSexta().'<hr>Sala: '.$gradeGerada->getSalaSexta().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaSabado().'<hr>Sala: '.$gradeGerada->getSalaSabado().'<hr>Professor: '.$professor.'</td>
                                                <td>'.$gradeGerada->getDisciplinaEad().'<hr>Sala: '.$gradeGerada->getSalaEad().'<hr>Professor: '.$professor.'</td>';
                                                echo '
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="<?php echo $url;?>?pagina=view_grades_listagem.php"><button onclick="javascript:iniciaRequisitaAjax('GET','view_blank.html','true');" type="button" class="btn btn-secondary">Voltar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
