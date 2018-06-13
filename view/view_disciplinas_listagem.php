<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Disciplinas</h3><hr />
        <!--<h6><strong>Clique no ícone <img src="../icons/error.png" alt="matriz"> para definir disciplina pré-requisito!</strong></h6>-->
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $curso = new Curso();
        $professor = new Professor();
        $disciplina = new Disciplina();
        $disciplinaDao = new DisciplinaDao();

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

        // Para listagem sem paginação
        //$selectDisciplina = $disciplinaDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectDisciplinaLimite = $disciplinaDao->listarLimite($conn, $inicio, $limite);

        $selectDisciplinaId = $disciplinaDao->listarId($conn);
        $resultado = $selectDisciplinaId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectDisciplinaId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listarDisciplinas">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Carga Horária</th>
                                    <th>Crédito</th>
                                    <th>Cursos</th>
                                    <th>Associar<br>Curso</th>
                                    <th>Professores</th>
                                    <th>Associar<br/>Professor</th>
                                    <th>Definir<br/>Pré-requisito</th>
                                    <th>Visualizar<br/>Pré-requisito</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaDisciplinaLimite = $selectDisciplinaLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaDisciplinaLimite as $dados) {
                                        $disciplina->setIdDisciplina($dados['iddisciplinas']);
                                        $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                        $disciplina->setCargaHoraria($dados['carga_horaria']);
                                        $disciplina->setCredito($dados['credito']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteDisciplinaAdmin('.$disciplina->getIdDisciplina().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteDisciplinaCoordenador('.$disciplina->getIdDisciplina().')';
                                        }

                                        $idDisciplina = $disciplina->getIdDisciplina();
                                        $selectCursoDisciplina = $disciplinaDao->buscarPorId($conn, $idDisciplina);
                                        foreach ($selectCursoDisciplina as $dados)
                                            $disciplina->setNomeDisciplina($dados['nome_disciplina']);                                        

                                        // Modal de Cursos
                                        echo '
                                        <div class="modal fade" id="exampleModalCurso'.$disciplina->getIdDisciplina().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Cursos da disciplina '; echo $disciplina->getNomeDisciplina(); echo '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">';
                                                        $selectCurso = $disciplinaDao->listarCurso($conn, $idDisciplina);
                                                        while ($linhaDisciplinaCurso = $selectCurso->fetchAll(PDO::FETCH_ASSOC)) {
                                                            foreach ($linhaDisciplinaCurso as $dados) {
                                                                $curso->setNome($dados['nome']);
                                                                $curso->setIdCurso($dados['idcurso']);
                                                                echo '<div style="font-size: 18px;">'.$curso->getNome().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_curso_desassociar.php&idCurso='.$curso->getIdCurso().'&idDisciplina='.$idDisciplina.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></div>';
                                                            }
                                                        }
                                                    echo '
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                                        // Modal de Professores
                                        echo '
                                        <div class="modal fade" id="exampleModalProfessor'.$disciplina->getIdDisciplina().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Professores da disciplina '; echo $disciplina->getNomeDisciplina(); echo '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">';
                                                        $selectProfessor = $disciplinaDao->listarProfessor($conn, $idDisciplina);
                                                        while ($linhaDisciplinaProfessor = $selectProfessor->fetchAll(PDO::FETCH_ASSOC)) {
                                                            foreach ($linhaDisciplinaProfessor as $dados) {
                                                                $professor->setNome($dados['nome']);
                                                                $professor->setIdProfessor($dados['idprofessor']);
                                                                echo '<div style="font-size: 18px;">'.$professor->getNome().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_professor_desassociar.php&idProfessor='.$professor->getIdProfessor().'&idDisciplina='.$idDisciplina.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></div>';
                                                            }
                                                        }
                                                    echo '
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                                        // Modal de disciplinas pré-requisitos
                                        echo '
                                        <div class="modal fade" id="exampleModalDisciplinaPreRequisito'.$disciplina->getIdDisciplina().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Disciplinas Pré-requisitos da disciplina '; echo $disciplina->getNomeDisciplina(); echo '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">';
                                                        $selectPreRequisito = $disciplinaDao->listarDisciplinaPreRequisito($conn, $idDisciplina);
                                                        while ($linhaDisciplinaPreRequisito = $selectPreRequisito->fetchAll(PDO::FETCH_ASSOC)) {
                                                            foreach ($linhaDisciplinaPreRequisito as $dados) {
                                                                $disciplina->setIdDisciplina($dados['disciplinas_iddisciplinas']);
                                                                $disciplina->setIdDisciplinaPreRequisito($dados['disciplinas_iddisciplinasprerequisito']);
                                                                $disciplina->setNomeDisciplina($dados['nome_disciplina']);

                                                                $selectNomeDisciplinaPreRequisito = $disciplinaDao->listarNomeDisciplinaPreRequisito($conn, $disciplina->getIdDisciplinaPreRequisito());
                                                                foreach ($selectNomeDisciplinaPreRequisito as $dados)
                                                                    $disciplina->setNomeDisciplinaPreRequisito($dados['nome_disciplina']);
                                                                    echo '<span style="font-size: 18px;">'.$disciplina->getNomeDisciplinaPreRequisito().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_disciplina_pre-requisito_desassociar.php&idDisciplinaPreRequisito='.$disciplina->getIdDisciplinaPreRequisito().'&idDisciplina='.$idDisciplina.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></span><br/>';
                                                            }
                                                        }
                                                    echo '
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left;">'.$disciplina->getNomeDisciplina().'</td>
                                                <td>'.$disciplina->getCargaHoraria().'</td>
                                                <td>'.$disciplina->getCredito().'</td>
                                                <td><a href="#" data-toggle="modal" data-target="#exampleModalCurso'.$disciplina->getIdDisciplina().'"><span data-feather="loader"></span></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_disciplina_curso_associar.php&idDisciplina='.$disciplina->getIdDisciplina().'"><span data-feather="paperclip"></span></a></td>
                                                <td><a href="#" data-toggle="modal" data-target="#exampleModalProfessor'.$disciplina->getIdDisciplina().'"><span data-feather="loader"></span></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_disciplina_associar.php&idDisciplina='.$disciplina->getIdDisciplina().'"><span data-feather="paperclip"></span></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_disciplina_pre-requisito.php&idDisciplina='.$disciplina->getIdDisciplina().'"><span data-feather="edit-3"></span></a></td>
                                                <td><a href="#" data-toggle="modal" data-target="#exampleModalDisciplinaPreRequisito'.$disciplina->getIdDisciplina().'"><span data-feather="loader"></span></a></td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_disciplina_update.php&idDisciplina='.$disciplina->getIdDisciplina().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <?php
                            // Navegação da tabela pela paginação
                            echo '<div style="text-align: center;">';
                                echo '<ul class="pagination justify-content-center">';
                                    if ($pg <= 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="<?php echo $url;?>?pagina=view_form_disciplina_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel-disciplina="listarDisciplinas" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br />
                </div>
            </div>
        </div>
    </div>
</div>
