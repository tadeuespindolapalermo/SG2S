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

        $disciplina = new Disciplina();
        $professorDao = new ProfessorDao();
        $professor = new Professor();

        $idProfessor = $_GET['idProfessor'];

        $selectDisciplinaProfessor = $professorDao->buscarPorId($conn, $idProfessor);
        foreach ($selectDisciplinaProfessor as $dados)
            $professor->setNome($dados['nome']);

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
        $selectDisciplina = $professorDao->listarDisciplina($conn, $idProfessor);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <h3 class="text-muted" style="text-align: center;">Disciplinas do Professor <?php echo $professor->getNome(); ?></h3><hr />

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Disciplinas do Professor <?php echo $professor->getNome(); ?> </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        while ($linhaProfessorDisciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC)) {
                                            foreach ($linhaProfessorDisciplina as $dados) {
                                                $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                                $disciplina->setIdDisciplina($dados['iddisciplinas']);
                                                echo '<div style="font-size: 18px;">'.$disciplina->getNomeDisciplina().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_disciplina_desassociar.php&idDisciplina='.$disciplina->getIdDisciplina().'&idProfessor='.$idProfessor.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></div>';
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
                        <a href="<?php echo $url;?>?pagina=view_professores_listagem.php"><button style="width: 200px; margin-left: 400px;" type="button" class="btn btn-info"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                    </div><br /><hr>
                    <div id="conteudo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
