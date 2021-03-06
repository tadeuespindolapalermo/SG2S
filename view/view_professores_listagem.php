<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Professores</h3><hr />
        <!--<h6><strong>Clique no ícone <span data-feather="layers"></span> para associar Professor à disciplina!</strong></h6>-->
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $professor = new Professor();
        $professorDao = new ProfessorDao();
        $disciplina = new Disciplina();

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
        //$selectProfessor = $professorDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectProfessorLimite = $professorDao->listarLimite($conn, $inicio, $limite);

        $selectProfessorId = $professorDao->listarId($conn);
        $resultado = $selectProfessorId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectProfessorId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listarProfessores">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>RG</th>
                                    <th>E-mail</th>
                                    <th>Fone</th>
                                    <th>Disciplina</th>
                                    <th>Associar</th>
                                    <th>Lixeira</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>

                            <?php
                                while ($linhaProfessorLimite = $selectProfessorLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaProfessorLimite as $dados) {
                                        $professor->setIdProfessor($dados['idprofessor']);
                                        $professor->setNome($dados['nome']);
                                        $professor->setCPF($dados['CPF']);
                                        $professor->setRG($dados['RG']);
                                        $professor->setEmail($dados['email']);
                                        $professor->setFone($dados['fone']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteProfessorProvisorioLixeiraAdmin('.$professor->getIdProfessor().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteProfessorProvisorioLixeiraCoordenador('.$professor->getIdProfessor().')';
                                        }

                                        $idProfessor = $professor->getIdProfessor();
                                        $selectDisciplinaProfessor = $professorDao->buscarPorId($conn, $idProfessor);
                                        foreach ($selectDisciplinaProfessor as $dados)
                                            $professor->setNome($dados['nome']);

                                        echo '
                                        <div class="modal fade" id="exampleModal'.$professor->getIdProfessor().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Disciplinas do Professor '; echo $professor->getNome(); echo '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">';
                                                        $selectDisciplina = $professorDao->listarDisciplina($conn, $idProfessor);
                                                        while ($linhaProfessorDisciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC)) {
                                                            foreach ($linhaProfessorDisciplina as $dados) {
                                                                $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                                                $disciplina->setIdDisciplina($dados['iddisciplinas']);
                                                                echo '<div style="font-size: 18px;">'.$disciplina->getNomeDisciplina().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_disciplina_desassociar.php&idDisciplina='.$disciplina->getIdDisciplina().'&idProfessor='.$idProfessor.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></div>';
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
                                                <td style="text-align: left;">'.$professor->getNome().'</td>
                                                <td>'.$professor->getCPF().'</td>
                                                <td>'.$professor->getRG().'</td>
                                                <td style="text-align: left;">'.$professor->getEmail().'</td>
                                                <td>'.$professor->getFone().'</td>
                                                <td><a href="#" data-toggle="modal" data-target="#exampleModal'.$professor->getIdProfessor().'"><span data-feather="loader"></span></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_professor_associar.php&idProfessor='.$professor->getIdProfessor().'"><span data-feather="paperclip"></span></a></td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_professor_update.php&idProfessor='.$professor->getIdProfessor().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
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
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '.php?pagina=view_professores_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="<?php echo $url;?>?pagina=view_form_professor_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel-usuario="listarProfessores" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <a href="<?php echo $url;?>?pagina=view_professores_lixeira_listagem.php"><button type="button" class="btn btn-danger"><span data-feather="user-x"></span>&nbsp;Lixeira</button></a>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
