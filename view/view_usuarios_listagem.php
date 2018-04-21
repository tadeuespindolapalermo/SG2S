<div class="container listar">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="../lib/jquery/buscaDinamica.js"></script>
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Usuários</h3><hr/>
        <small>ATENÇÃO: <strong><?= $_SESSION['nome'] ?></strong>, altere seus dados cadastrais somente através da opção do Dashboard para que seus dados de sessão sejam atualizados!</small>
    </div>

    <?php
        session_start();

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $usuarios = new Usuarios();
        $perfil = new Perfil();
        $usuarioDao = new UsuarioDao();

        if($_SESSION['perfil_idperfil'] == 2) {
            unset($_SESSION['usuario']);
            unset($_SESSION['email']);
            session_destroy();
            header('Location: ../controller/controller_sair.php');
        }

        $selectUsuarioJoin = $usuarioDao->listar($conn);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaUsuarios">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th style="text-align: left;">Nome</th>
                                    <th style="text-align: left;">Usuário</th>
                                    <th>Perfil</th>
                                    <th style="text-align: left;">E-mail</th>
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

                                        if ($_SESSION['nome'] != $usuarios->getNome()) {
                                            $stringImg = '<td><a href="view_admin.php?pagina=view_form_usuario_update.php&idUsuario='.$usuarios->getIdUsuarios().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>';
                                        } else {
                                            $stringImg = '<td><a href="javascript:void(null);" onclick="msgUpdateUsuarios()"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>';
                                        }

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$usuarios->getIdUsuarios().'</td>
                                                <td style="text-align: left;">'.$usuarios->getNome().'</td>
                                                <td style="text-align: left;">'.$usuarios->getUsuario().'</td>
                                                <td>'.$perfil->getDescricao().'</td>
                                                <td style="text-align: left;">'.$usuarios->getEmail().'</td>
                                                <td>'.$usuarios->getFone().'</td>
                                                <td><a href="javascript:void(null);" onclick="msgConfirmaDeleteUsuario('.$usuarios->getIdUsuarios().')"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                '.$stringImg.'
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="view_admin.php?pagina=view_form_usuario_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="user"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaUsuarios" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
