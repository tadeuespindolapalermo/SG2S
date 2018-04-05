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
            header('Location: ../processamento/sair.php');
        }

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $strSqlUsuario= "
        SELECT
            idusuarios,
            nome,
            fone,
            email,
            usuario
        FROM
            usuarios";

        $strSqlPerfilUsuario= "
        SELECT
            perfil_idperfil
        FROM
            usuario_perfil";

        $selectUsuario = $conn->prepare($strSqlUsuario);
        $selectUsuario->execute();

        $selectPerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
        $selectPerfilUsuario->execute();
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
                                while (($linhaUsuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC)) && ($linhaPerfilUsuario = $selectPerfilUsuario->fetchAll(PDO::FETCH_ASSOC))) {

                                    foreach ($linhaPerfilUsuario as $dados) {
                                        $perfil_idperfil = $dados['perfil_idperfil'];                                        
                                    }

                                    if ($perfil_idperfil == 1) {
                                        $linhaPerfilUsuarioTable = 'Administrador';
                                    } elseif ($perfil_idperfil == 2) {
                                        $linhaPerfilUsuarioTable = 'Coordenador';
                                    }

                                    foreach ($linhaUsuario as $dados) {
                                        $idusuarios = $dados['idusuarios'];
                                        $nome = $dados['nome'];
                                        $usuario = $dados['usuario'];
                                        $email = $dados['email'];
                                        $fone = $dados['fone'];

                                        echo '
                                        <tbody>
                                            <tr>
                                                <td>'.$idusuarios.'</td>
                                                <td>'.$nome.'</td>
                                                <td>'.$usuario.'</td>
                                                <td>'.$linhaPerfilUsuarioTable.'</td>
                                                <td>'.$email.'</td>
                                                <td>'.$fone.'</td>
                                                <td><a style="margin-left: 20px;" href="admin.php?pagina=../processamento/usuario_remove.php&idUsuario='.$idusuarios.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a style="margin-left: 10px;" href="admin.php?pagina=view_usuarios_update.php&idUsuario='.$idusuarios.'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <a href="admin.php?pagina=cadastros_usuarios_admin.php"><button type="button" class="btn btn-primary"><img src="../lib/open-iconic/svg/person.svg" alt="exportarExcel">&nbsp;Novo Usuário</button></a>
                        <button export-to-excel="listaUsuarios" class="btn btn-success">
                            <i><img src="../lib/open-iconic/svg/share-boxed.svg" alt="exportarExcel"></i>&nbsp;Exportar Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
