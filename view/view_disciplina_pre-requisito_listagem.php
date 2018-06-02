<div class="container listar">
    <div class="header clearfix">
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $disciplinaDao = new DisciplinaDao();
        $disciplina = new Disciplina();

        $idDisciplina = $_GET['idDisciplina'];

        $selectDisciplinaPreRequisito = $disciplinaDao->buscarPorId($conn, $idDisciplina);
        foreach ($selectDisciplinaPreRequisito as $dados)
            $disciplina->setNomeDisciplina($dados['nome_disciplina']);

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

        //Para listagem sem paginação
        $selectPreRequisito = $disciplinaDao->listarDisciplinaPreRequisito($conn, $idDisciplina);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <h3 class="text-muted" style="text-align: center;">Disciplinas Pré-requisitos da disciplina <?php echo $disciplina->getNomeDisciplina(); ?></h3><hr />

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Disciplinas Pré-requisitos da disciplina <?php echo $disciplina->getNomeDisciplina(); ?> </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
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
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <!--<button export-to-excel="listaMatriz" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>-->

                        <!-- Button trigger modal -->
                        <button style="width: 200px; margin-left: 400px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Visualizar
                        </button><br/><br/>

                        <!--<button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>-->
                        <a href="<?php echo $url;?>?pagina=view_disciplinas_listagem.php"><button style="width: 200px; margin-left: 400px;" type="button" class="btn btn-info"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                    </div><br /><hr>
                    <div id="conteudo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
