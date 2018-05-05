<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Matriz</h3><hr />
    </div>

    <?php
        session_start();

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $matriz = new Matriz();
        $matrizDao = new MatrizDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectMatriz = $matrizDao->listar($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaMatrizes">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Disciplina</th>
                                    <th>Curso</th>
                                    <th>Carga Horária</th>
                                    <th>Crédito</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaMatriz as $dados) {
                                        $matriz->setIdMatrizCurricular($dados['idmatriz_curricular']);
                                        $matriz->setCursoIdCurso($dados['curso_idcurso']);
                                        $matriz->setCursoNome($dados['nome']);
                                        $matriz->setNomeMatriz($dados['nome_matriz']);
                                        $matriz->setCargaHoraria($dados['carga_horaria']);
                                        $matriz->setCredito($dados['credito']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$matriz->getIdMatrizCurricular().'</td>
                                                <td style="text-align: left;">'.$matriz->getNomeMatriz().'</td>
                                                <td style="text-align: left;">'.$matriz->getCursoNome().'</td>
                                                <td>'.$matriz->getCargaHoraria().'</td>
                                                <td>'.$matriz->getCredito().'</td>
                                                <td><a href="javascript:void(null);" onclick="msgConfirmaDeleteMatriz('.$matriz->getIdMatrizCurricular().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_matriz_update.php&idMatriz='.$matriz->getIdMatrizCurricular().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_matriz_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaMatrizes" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br />
                </div>
            </div>
        </div>
    </div>
</div>
