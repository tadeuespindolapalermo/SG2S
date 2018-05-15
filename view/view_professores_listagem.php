<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Professores</h3><hr />
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

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectProfessor = $professorDao->listar($conn);

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
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaProfessores">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>RG</th>
                                    <th>E-mail</th>
                                    <th>Fone</th>
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
                        <?php
                            // Navegação da tabela pela paginação
                            echo '<div style="margin: cent;">';
                                echo '<ul class="pagination justify-content-center">';
                                    if ($pg <= 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="view_admin.php?pagina=view_professores_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="view_admin.php?pagina=view_professores_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'>".$i."</a></li>&nbsp";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='view_admin.php?pagina=view_professores_listagem.php&pg=$i'>".$i."</a></li>&nbsp";
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag) {
                                        echo "<li class='page-item disabled'><a class='page-link' href='view_admin.php?pagina=view_professores_listagem.php&pg=$qtdPag'>Final</a></li>&nbsp";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='view_admin.php?pagina=view_professores_listagem.php&pg=$qtdPag'>Final</a></li>&nbsp";
                                    }
                                echo '</ul>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="view_admin.php?pagina=view_form_professor_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaProfessores" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <a href="view_admin.php?pagina=view_professores_lixeira_listagem.php"><button type="button" class="btn btn-danger"><span data-feather="user-x"></span>&nbsp;Lixeira</button></a>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
