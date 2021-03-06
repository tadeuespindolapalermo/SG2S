<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Cursos</h3><hr/>
        <!--<h6><strong>Clique no ícone <img src="../icons/infor.png" alt="matriz"> para visualizar a Matriz!</strong></h6>-->
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        //$idCurso = $_GET['idCurso'];

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $curso = new Curso();
        $cursoDao = new CursoDao();
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
        //$selectCurso = $cursoDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectCursoLimite = $cursoDao->listarLimite($conn, $inicio, $limite);

        $selectCursoId = $cursoDao->listarId($conn);
        $resultado = $selectCursoId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectCursoId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listarCursos">
                            <thead>
                                <tr>
                                    <th>Nome do Curso</th>
                                    <th>Portaria</th>
                                    <th>Duração</th>
                                    <th>Grau</th>
                                    <th>Data Portaria</th>
                                    <th>Versão Matriz</th>
                                    <th>MATRIZ</th>
                                    <th>ASSOCIAR</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaCursoLimite = $selectCursoLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaCursoLimite as $dados) {
                                        $curso->setIdCurso($dados['idcurso']);
                                        $curso->setNome($dados['nome']);
                                        $curso->setPortaria($dados['portaria']);
                                        $curso->setDuracao($dados['duracao']);
                                        $curso->setGrau($dados['grau']);
                                        $curso->setDataPortaria($dados['data_portaria']);
                                        $curso->setVersaoMatriz($dados['versao_matriz']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteCursoAdmin('.$curso->getIdCurso().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteCursoCoordenador('.$curso->getIdCurso().')';
                                        }

                                        $idCurso = $curso->getIdCurso();
                                        $selectMatrizCurso = $cursoDao->buscarPorId($conn, $idCurso);
                                        foreach ($selectMatrizCurso as $dados) {
                                            $curso->setNome($dados['nome']);
                                        }

                                        echo '
                                        <div class="modal fade" id="exampleModal'.$curso->getIdCurso().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Matriz do Curso de '; echo $curso->getNome(); echo '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">';
                                                        $selectMatriz = $cursoDao->listarMatriz($conn, $idCurso);
                                                        while ($linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC)) {
                                                            foreach ($linhaMatriz as $dados) {
                                                                $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                                                $disciplina->setIdDisciplina($dados['iddisciplinas']);
                                                                echo '<div style="font-size: 18px;">'.$disciplina->getNomeDisciplina().' - <a href="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_matriz_desassociar.php&idDisciplina='.$disciplina->getIdDisciplina().'&idCurso='.$idCurso.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"><a/></div>';
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
                                                <td>'.$curso->getNome().'</td>
                                                <td>'.$curso->getPortaria().'</td>
                                                <td>'.$curso->getDuracao().'</td>
                                                <td>'.$curso->getGrau().'</td>
                                                <td>'.$curso->getDataPortaria().'</td>
                                                <td>'.$curso->getVersaoMatriz().'</td>
                                                <td><a href="#" data-toggle="modal" data-target="#exampleModal'.$curso->getIdCurso().'"><span data-feather="loader"></span></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_curso_associar.php&idCurso='.$curso->getIdCurso().'"><span data-feather="paperclip"></span></a></td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_curso_update.php&idCurso='.$curso->getIdCurso().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>

                        <!-- PAGINADOR -->
                        <?php
                            // Navegação da tabela pela paginação
                            echo '<div style="text-align: center;">';
                                echo '<ul class="pagination justify-content-center">';
                                    if ($pg <= 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="<?php echo $url;?>?pagina=view_form_curso_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel-curso="listarCursos" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
