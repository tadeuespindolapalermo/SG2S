<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Usuários</h3>
        <small>ATENÇÃO: <strong><?= $_SESSION['nome'] ?></strong>, altere seus dados cadastrais somente através da opção ao lado para que seus dados de sessão sejam atualizados!</small>
    </div>

    <?php
        session_start();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../processamento/process_sair.php');
        }

        require('../db/Config.inc.php');

        $usuarios = new Usuarios();
        $perfil = new Perfil();

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $strSqlJoin= "
        SELECT
            *
        FROM
            usuarios INNER JOIN usuario_perfil ON usuarios.idusuarios = usuario_perfil.idusuario_perfil";

        $selectUsuarioJoin = $conn->prepare($strSqlJoin);
        $selectUsuarioJoin->execute();
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="listaUsuarios">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Usuário</th>
                                    <th>Perfil</th>
                                    <th>E-mail</th>
                                    <th>Telefone</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaUsuarioJoin = $selectUsuarioJoin->fetchAll(PDO::FETCH_ASSOC)) {

                                    foreach ($linhaUsuarioJoin as $dados) {

                                        $perfil->setIdPerfil($dados['perfil_idperfil']);

                                        if ($perfil->getIdPerfil() == 1) {
                                            $perfil->setDescricao('Administrador');
                                        } elseif ($perfil->getIdPerfil() == 2) {
                                            $perfil->setDescricao('Coordenador');
                                        }

                                        $usuarios->setIdUsuarios($dados['idusuarios']);
                                        $usuarios->setNome($dados['nome']);
                                        $usuarios->setUsuario($dados['usuario']);
                                        $usuarios->setEmail($dados['email']);
                                        $usuarios->setFone($dados['fone']);
                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$usuarios->getIdUsuarios().'</td>
                                                <td>'.$usuarios->getNome().'</td>
                                                <td>'.$usuarios->getUsuario().'</td>
                                                <td>'.$perfil->getDescricao().'</td>
                                                <td>'.$usuarios->getEmail().'</td>
                                                <td>'.$usuarios->getFone().'</td>
                                                <td><a style="margin-left: 20px;" href="view_admin.php?pagina=../processamento/process_usuario_remove.php&idUsuario='.$usuarios->getIdUsuarios().'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a style="margin-left: 10px;" href="view_admin.php?pagina=view_form_usuario_update.php&idUsuario='.$usuarios->getIdUsuarios().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_usuario_cadastro.php"><button type="button" class="btn btn-primary"><img src="../lib/open-iconic/svg/person.svg" alt="exportarExcel">&nbsp;Novo Usuário</button></a>
                        <button export-to-excel="listaUsuarios" class="btn btn-success">
                            <i><img src="../lib/open-iconic/svg/share-boxed.svg" alt="exportarExcel"></i>&nbsp;Exportar Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
