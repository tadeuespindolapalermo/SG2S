<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Disciplinas</h3><hr />
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $disciplina = new Disciplina();
        $disciplinaDao = new DisciplinaDao();

        /*if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }*/

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
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaDisciplinas">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>Carga Horária</th>
                                    <th>Crédito</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaDisciplinaLimite = $selectDisciplinaLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaDisciplinaLimite as $dados) {
                                        $disciplina->setIdDisciplina($dados['iddisciplinas']);
                                        $disciplina->setCursoIdCurso($dados['curso_idcurso']);
                                        $disciplina->setCursoNome($dados['nome']);
                                        $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                        $disciplina->setCargaHoraria($dados['carga_horaria']);
                                        $disciplina->setCredito($dados['credito']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $url = 'view_admin.php';
                                            $alert = 'msgConfirmaDeleteDisciplinaAdmin('.$disciplina->getIdDisciplina().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $url = 'view_coordenador.php';
                                            $alert = 'msgConfirmaDeleteDisciplinaCoordenador('.$disciplina->getIdDisciplina().')';
                                        }

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left;">'.$disciplina->getNomeDisciplina().'</td>
                                                <td style="text-align: left;">'.$disciplina->getCursoNome().'</td>
                                                <td>'.$disciplina->getCargaHoraria().'</td>
                                                <td>'.$disciplina->getCredito().'</td>
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
                        <button export-to-excel="listaDisciplinas" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br />
                </div>
            </div>
        </div>
    </div>
</div>
