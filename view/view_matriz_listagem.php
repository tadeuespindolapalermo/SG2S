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
        $cursoDao = new CursoDao();
        $curso = new Curso();

        $idCurso = $_GET['idCurso'];

        $selectMatrizCurso = $cursoDao->buscarPorId($conn, $idCurso);
        foreach ($selectMatrizCurso as $dados)
            $curso->setNome($dados['nome']);

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
        $selectMatriz = $cursoDao->listarMatriz($conn, $idCurso);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <h3 class="text-muted">Matriz do Curso de <?php echo $curso->getNome(); ?></h3><hr />
                        <table style="text-align: center; width: 400px; margin-left: 320px;" class="table table-hover table-striped listaSearch" id="listaMatriz">
                            <thead>
                                <tr>
                                    <th>Disciplinas</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaMatriz = $selectMatriz->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaMatriz as $dados) {
                                        $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$disciplina->getNomeDisciplina().'</td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <br/>
                        <!--<button export-to-excel="listaMatriz" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>-->
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                        <a href="<?php echo $url;?>?pagina=view_cursos_listagem.php"><button type="button" class="btn btn-info"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                    </div><br /><hr>
                    <div id="conteudo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
