<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Grades</h3><hr />
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

        $selectGrade = $gradeDao->listar($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" id="listaGrades" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ano Letivo</th>
                                    <th>Semestre</th>
                                    <th>Período</th>
                                    <th>Horário</th>
                                    <th>Sala</th>
                                    <th>Qtd. Alunos</th>
                                    <th>Turmas</th>
                                    <th>Curso</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
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
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$grade->getIdGradeSemestral().'</td>
                                                <td>'.$grade->getAnoLetivo().'</td>
                                                <td>'.$grade->getSemestre().'</td>
                                                <td>'.$grade->getPeriodo().'</td>
                                                <td>'.$grade->getHorario().'</td>
                                                <td>'.$grade->getSala().'</td>
                                                <td>'.$grade->getQuantidadeAlunos().'</td>
                                                <td>'.$grade->getTurmas().'</td>
                                                <td>'.$grade->getCursoNome().'</td>
                                                <td><a href="javascript:void(null);" onclick="msgConfirmaDeleteGrade('.$grade->getIdGradeSemestral().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_grade_update.php&idGrade='.$grade->getIdGradeSemestral().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_grade_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="user"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaGrades" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button type="button" onclick="javascript:iniciaRequisitaAjax('GET','view_form_grade_gerar.php','true');" class="btn btn-dark"><span data-feather="layers"></span>&nbsp;Gerar</button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br /><hr>
                    <div id="conteudo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
