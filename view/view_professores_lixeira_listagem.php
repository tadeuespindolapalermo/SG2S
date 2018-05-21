<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Professores na Lixeira</h3><hr />
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

        if ($_SESSION['perfil_idperfil'] == 1) {
            $url = 'view_admin.php';
        } elseif ($_SESSION['perfil_idperfil'] == 2) {
            $url = 'view_coordenador.php';
        }

        /*if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }*/

        // Para listagem sem paginação
        //$selectProfessor = $professorDao->listarExcluidos($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectProfessorLimiteLixeira = $professorDao->listarLimiteLixeira($conn, $inicio, $limite);

        $selectProfessorIdLixeira = $professorDao->listarIdLixeira($conn);
        $resultado = $selectProfessorIdLixeira->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectProfessorIdLixeira->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaProfessoresExcluidos">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>RG</th>
                                    <th>E-mail</th>
                                    <th>Fone</th>
                                    <th>Excluir</th>
                                    <th>Recuperar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaProfessorLimiteLixeira = $selectProfessorLimiteLixeira->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaProfessorLimiteLixeira as $dados) {
                                        $professor->setIdProfessor($dados['idprofessor']);
                                        $professor->setNome($dados['nome']);
                                        $professor->setCPF($dados['CPF']);
                                        $professor->setRG($dados['RG']);
                                        $professor->setEmail($dados['email']);
                                        $professor->setFone($dados['fone']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteProfessorDefinitivoBancoDadosAdmin('.$professor->getIdProfessor().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteProfessorDefinitivoBancoDadosCoordenador('.$professor->getIdProfessor().')';
                                        }

                                        echo '
                                        <tbody>
                                            <tr>                                            
                                                <td style="text-align: left;">'.$professor->getNome().'</td>
                                                <td>'.$professor->getCPF().'</td>
                                                <td>'.$professor->getRG().'</td>
                                                <td style="text-align: left;">'.$professor->getEmail().'</td>
                                                <td>'.$professor->getFone().'</td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_professor_recuperar.php&idProfessor='.$professor->getIdProfessor().'"><img src="../lib/open-iconic/svg/action-undo.svg" alt="editar"></a></td>
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
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_lixeira_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_lixeira_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_lixeira_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_lixeira_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_professores_lixeira_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <button export-to-excel="listaProfessoresExcluidos" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <a href="<?php echo $url;?>?pagina=view_professores_listagem.php"><button type="button" class="btn btn-info"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
