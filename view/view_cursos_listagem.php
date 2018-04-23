<div class="container listar">        
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Cursos</h3><hr />
    </div>


    <?php
        session_start();

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $curso = new Curso();
        $cursoDao = new CursoDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectCurso = $cursoDao->listar($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaCursos">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th style="text-align: left;">Nome</th>
                                    <th>Portaria</th>
                                    <th>Duração</th>
                                    <th>Grau</th>
                                    <th>Data Portaria</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaCurso = $selectCurso->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaCurso as $dados) {
                                        $curso->setIdCurso($dados['idcurso']);
                                        $curso->setNome($dados['nome']);
                                        $curso->setPortaria($dados['portaria']);
                                        $curso->setDuracao($dados['duracao']);
                                        $curso->setGrau($dados['grau']);
                                        $curso->setDataPortaria($dados['data_portaria']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$curso->getIdCurso().'</td>
                                                <td style="text-align: left;">'.$curso->getNome().'</td>
                                                <td>'.$curso->getPortaria().'</td>
                                                <td>'.$curso->getDuracao().'</td>
                                                <td>'.$curso->getGrau().'</td>
                                                <td>'.$curso->getDataPortaria().'</td>
                                                <td><a href="javascript:void(null);" onclick="msgConfirmaDeleteCurso('.$curso->getIdCurso().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="view_admin.php?pagina=view_form_curso_update.php&idCurso='.$curso->getIdCurso().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_curso_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="user"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaCursos" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
