<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Grades Semestrais</h3><hr />
        <h6><strong>Clique no ícone <img src="../icons/accept.png" alt="gerar"> para gerar uma grade horária!</strong></h6>
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $gradeSemestral = new GradeSemestral();
        $gradeSemestralDao = new GradeSemestralDao();

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
        //$selectGradeSemestral = $gradeSemestralDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectGradeSemestralLimite = $gradeSemestralDao->listarLimite($conn, $inicio, $limite);

        $selectGradeSemestralId = $gradeSemestralDao->listarId($conn);
        $resultado = $selectGradeSemestralId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectGradeSemestralId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" id="listaGradesSemestrais" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>GERAR</th>
                                    <th>Ano Letivo</th>
                                    <th>Semestre Letivo</th>
                                    <th>Turno</th>
                                    <th>Horário</th>
                                    <th>Curso</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaGradeSemestralLimite = $selectGradeSemestralLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaGradeSemestralLimite as $dados) {
                                        $gradeSemestral->setIdGradeSemestral($dados['idgrade_semestral']);
                                        $GLOBALS['idGradeSemestral'] = $gradeSemestral->getIdGradeSemestral();
                                        $gradeSemestral->setAnoLetivo($dados['ano_letivo']);
                                        $gradeSemestral->setSemestreLetivo($dados['semestre_letivo']);
                                        $gradeSemestral->setTurno($dados['turno']);
                                        $gradeSemestral->setHorario($dados['horario']);
                                        $gradeSemestral->setCursoIdCurso($dados['curso_idcurso']);
                                        $gradeSemestral->setCursoNome($dados['nome']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteGradeSemestralAdmin('.$gradeSemestral->getIdGradeSemestral().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteGradeSemestralCoordenador('.$gradeSemestral->getIdGradeSemestral().')';
                                        }

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_grade_horaria_cadastro.php&idGradeSemestral='.$gradeSemestral->getIdGradeSemestral().'"><img src="../icons/accept.png" alt="gerar"></a></td>
                                                <td>'.$gradeSemestral->getAnoLetivo().'</td>
                                                <td>'.$gradeSemestral->getSemestreLetivo().'</td>
                                                <td>'.$gradeSemestral->getTurno().'</td>
                                                <td>'.$gradeSemestral->getHorario().'</td>
                                                <td>'.$gradeSemestral->getCursoNome().'</td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_grade_semestral_update.php&idGradeSemestral='.$gradeSemestral->getIdGradeSemestral().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
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
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="<?php echo $url;?>?pagina=view_form_grade_semestral_cadastro.php"><button type="button" class="btn btn-info"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaGradesSemestrais" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <!--<button type="button" onclick="javascript:iniciaRequisitaAjax('GET','view_grades_geradas.php','true');" class="btn btn-dark"><span data-feather="layers"></span>&nbsp;Geradas</button>-->
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br /><hr>
                    <div id="conteudo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
