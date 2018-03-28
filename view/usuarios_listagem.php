<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Usuários</h3>
    </div>

    <?php
        session_start();

        if($_SESSION['perfil_idperfil'] == 2) {
            header('Location: ../processamento/sair.php');
        }

        require_once('../db/Conexao.class.php');

        $usuarioSessao = $_SESSION['usuario'];

        $objConexao = new Conexao();
        $link = $objConexao->conectar();

        $strSql= "
        SELECT
            idusuarios,
            nome,
            fone,
            email,
            usuario
        FROM
            usuarios";

        $rs = $objConexao->executarConsulta($link, $strSql);

        //$linha = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Usuário</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linha = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
                                    echo '
                                    <tbody>
                                        <tr>
                                            <td>'.$linha['idusuarios'].'</td>
                                            <td>'.$linha['nome'].'</td>
                                            <td>'.$linha['fone'].'</td>
                                            <td>'.$linha['email'].'</td>
                                            <td>'.$linha['usuario'].'</td>
                                            <td><a style="margin-left: 20px;" href="admin.php?pagina=../processamento/usuario_remove.php&idUsuario='.$linha['idusuarios'].'"><img src="../lib/open-iconic/svg/trash.svg" alt="remover"></a></td>
                                            <td><a style="margin-left: 10px;" href="admin.php?pagina=view_usuarios_update.php&idUsuario='.$linha['idusuarios'].'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                        </tr>
                                    </tbody>';
                                }
                            ?>
                        </table>
                        <a href="admin.php?pagina=cadastros_usuarios_admin.php"><button type="button" class="btn btn-primary">Novo Cadastro</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
