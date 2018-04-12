<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Professores Excluídos</h3>
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

        $selectProfessor = $professorDao->listarExcluidos($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="listaProfessoresExcluidos">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>RG</th>
                                    <th>E-mail</th>
                                    <th>Fone</th>
                                    <th>Eliminar</th>
                                    <th>Recuperar</th>
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
                                                <td>'.$professor->getNome().'</td>
                                                <td>'.$professor->getCPF().'</td>
                                                <td>'.$professor->getRG().'</td>
                                                <td>'.$professor->getEmail().'</td>
                                                <td>'.$professor->getFone().'</td>
                                                <td><a style="margin-left: 26px;" href="view_admin.php?pagina=../controller/controller_professor_remove_definitivo.php&idProfessor='.$professor->getIdProfessor().'"><img src="../lib/open-iconic/svg/trash.svg" alt="remover"></a></td>
                                                <td><a style="margin-left: 28px;" href="view_admin.php?pagina=../controller/controller_professor_recuperar.php&idProfessor='.$professor->getIdProfessor().'"><img src="../lib/open-iconic/svg/action-undo.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <button export-to-excel="listaProfessoresExcluidos" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <a href="view_admin.php?pagina=view_professores_listagem.php"><button type="button" class="btn btn-info"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
