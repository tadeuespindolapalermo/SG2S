<?php
    session_start();

    $erro_update = isset($_GET['erro_update']) ? $_GET['erro_update'] : 0;

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuario = new Usuarios();
    $perfil = new Perfil();
    $usuarioDao = new UsuarioDao();

    $idUsuarioSessao = $_SESSION['idusuarios'];

    $selectUsuario = $usuarioDao->buscarUsuarioLogado($conn, $idUsuarioSessao);
    $linhaUsuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaUsuario as $dados) {
        $usuario->setNome($dados['nome']);
        $usuario->setUsuario($dados['usuario']);
        $usuario->setEmail($dados['email']);
        $usuario->setFone($dados['fone']);
    }

    if($erro_update) {
        echo '<div style="margin-left: 18px;"><font color="#FF0000"><strong>Erro ao atualizar! Modifique algum dado no formulário!</strong></font></div>';
    }

    echo '
    <div class="container">
        <h3 class="text-muted">Atualizar Dados Cadastrais</h3>
        <form action="../controller/controller_form_usuario_logado_update.php" method="post">
            <div class="form-group">
                <div class="col-lg-13">
                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$usuario->getNome().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$usuario->getFone().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" value="'.$usuario->getUsuario().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$usuario->getEmail().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input type="password" style="width: 300px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="'.$_SESSION['senha'].'" required disabled><br/>

                    <button id="btnSalvar" type="submit" class="btn btn-success" disabled>Salvar</button>
                    <button type="button" onclick="alterarDisabled()" class="btn btn-info">Editar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
