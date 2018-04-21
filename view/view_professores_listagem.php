<div class="container listar">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="../lib/jquery/buscaDinamica.js"></script>
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Professores</h3><hr />
    </div>

    <?php
        session_start();

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $professor = new Professor();
        $professorDao = new ProfessorDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectProfessor = $professorDao->listar($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaProfessores">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th style="text-align: left;">Nome</th>
                                    <th>CPF</th>
                                    <th>RG</th>
                                    <th style="text-align: left;">E-mail</th>
                                    <th>Fone</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaProfessor = $selectProfessor->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaProfessor as $dados) {
                                        $professor->setIdProfessor($dados['idprofessor']);
                                        $professor->setNome($dados['nome']);
                                        $professor->setCPF($dados['CPF']);
                                        $professor->setRG($dados['RG']);
                                        $professor->setEmail($dados['email']);
                                        $professor->setFone($dados['fone']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$professor->getIdProfessor().'</td>
                                                <td style="text-align: left;">'.$professor->getNome().'</td>
                                                <td>'.$professor->getCPF().'</td>
                                                <td>'.$professor->getRG().'</td>
                                                <td style="text-align: left;">'.$professor->getEmail().'</td>
                                                <td>'.$professor->getFone().'</td>
                                                <td><a href="javascript:void(null);" onclick="msgConfirmaDeleteProfessorProvisorioLixeira('.$professor->getIdProfessor().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_professor_update.php&idProfessor='.$professor->getIdProfessor().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_professor_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="user"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaProfessores" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <a href="view_admin.php?pagina=view_professores_excluidos_listagem.php"><button type="button" class="btn btn-danger"><span data-feather="user-x"></span>&nbsp;Lixeira</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
