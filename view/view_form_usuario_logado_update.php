<?php
    session_start();

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

    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">'.strtoupper($usuario->getNome()).'.</font><strong></h5></div><br />
            <form action="../controller/controller_form_usuario_logado_update.php" method="post">
                <div class="form-group">

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" placeholder="*Nome - Máximo 60 caracteres." value="'.$usuario->getNome().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 320px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" placeholder="*Telefone (xx) x xxxx-xxxx" value="'.$usuario->getFone().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" maxlength="40" style="width: 320px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" placeholder="*Usuário - Máximo 40 caracteres." value="'.$usuario->getUsuario().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="email" name="email" class="form-control" placeholder="*E-mail: nome@provedor.com - máx 60" value="'.$usuario->getEmail().'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label><br/>
                    <small>ATENÇÃO: Senha apenas com 8 caracteres.</small><br/>
                    <small>MÍNIMO: 1 número, 1 letra maiúscula e 1 letra minúscula.</small>
                    <input type="password" pattern="^(?=.*[a-zç])(?=.*[A-ZÇ])(?=.*\d)[\S\s]{8,}$" style="width: 320px; margin-bottom: -5px;"
                    id="senha" name="senha" class="form-control" value="'.$_SESSION['senha'].'"
                    required disabled placeholder="Somente 8 caracteres" maxlength="8"><br/>

                    <button id="btnSalvar" type="submit" class="btn btn-outline-success form-control" style="margin-bottom: 5px;" disabled>Salvar</button><br/>
                    <button id="btnEditar" type="button" onclick="alterarDisabledEditar()" style="margin-bottom: 5px;" class="btn btn-outline-info form-control">Editar</button><br/>
                    <button id="btnProteger" type="button" onclick="alterarDisabledProteger()" style="margin-bottom: 5px;" class="btn btn-outline-secondary form-control" disabled>Proteger</button><br/>
                    <button id="btnVoltarInicio" type="button" onclick="voltarInicio()" class="btn btn-outline-secondary form-control">Voltar Início</button>
                </div>
            </form>
        </div>
    </div>';
