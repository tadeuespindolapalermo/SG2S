<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Usuários</h3><hr/>
        <small>ATENÇÃO: <strong><?= $_SESSION['nome'] ?></strong>, altere seus dados cadastrais somente através da opção do Dashboard para que seus dados de sessão sejam atualizados!</small>
    </div>

    <?php
        session_start();
        ob_start();
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

        // Para listagem sem paginação
        //$selectUsuarioJoin = $usuarioDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectUsuarioLimite = $usuarioDao->listarLimite($conn, $inicio, $limite);

        $selectUsuarioId = $usuarioDao->listarId($conn);
        $resultado = $selectUsuarioId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectUsuarioId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" style="text-align: center;" id="listaUsuarios">
                            <thead>
                                <tr>
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
                                while ($linhaUsuarioLimite = $selectUsuarioLimite->fetchAll(PDO::FETCH_ASSOC)) {

                                    foreach ($linhaUsuarioLimite as $dados) {

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
                        <?php
                            // Navegação da tabela pela paginação
                            echo '<div style="text-align: center;">';
                                echo '<ul class="pagination justify-content-center">';
                                    if ($pg <= 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="view_admin.php?pagina=view_usuarios_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="view_admin.php?pagina=view_usuarios_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='view_admin.php?pagina=view_usuarios_listagem.php&pg=$i'>".$i."</a></li>&nbsp";
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo "<li class='page-item disabled'><a class='page-link' href='view_admin.php?pagina=view_usuarios_listagem.php&pg=$qtdPag'>Final</a></li>&nbsp";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='view_admin.php?pagina=view_usuarios_listagem.php&pg=$qtdPag'>Final</a></li>&nbsp<br/>";
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <a href="view_admin.php?pagina=view_form_usuario_cadastro.php"><button type="button" class="btn btn-primary"><span data-feather="plus-circle"></span>&nbsp;Novo</button></a>
                        <button export-to-excel="listaUsuarios" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
