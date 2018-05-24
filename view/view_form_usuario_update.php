<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuario = new Usuarios();
    $perfil = new Perfil();
    $usuarioDao = new UsuarioDao();

    $idUsuario = $_GET['idUsuario'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectUsuario = $usuarioDao->buscarUsuarioId($conn, $idUsuario);
    $linhaUsuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaUsuario as $dados) {
        $usuario->setIdUsuarios($dados['idusuarios']);
        $usuario->setNome($dados['nome']);
        $usuario->setUsuario($dados['usuario']);
        $usuario->setEmail($dados['email']);
        $usuario->setFone($dados['fone']);
    }

    $selectPerfilUsuario = $usuarioDao->buscarPerfilId($conn, $idUsuario);
    $linhaPerfilUsuario = $selectPerfilUsuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaPerfilUsuario as $dados)
        $perfil->setIdPerfil($dados['perfil_idperfil']);

    if($perfil->getIdPerfil() == 1) {
        $perfil->setDescricao("Administrador");
        $strLinhaPerfilDescricaoOption = "Coordenador";
    } elseif ($perfil->getIdPerfil() == 2) {
        $perfil->setDescricao("Coordenador");
        $strLinhaPerfilDescricaoOption = "Administrador";
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <div style="text-align: center;"><h4><strong>Atualizar Usuário</strong></h4></div>
            <div style="text-align: center;"><h5><strong><font color="#FF0000">'.strtoupper($usuario->getNome()).'</font><strong></h5></div>
            <form action="view_admin.php?pagina=../controller/controller_form_usuario_update.php&idUsuario='.$usuario->getIdUsuarios().'" method="post">
                <div class="form-group ">

                    <div style="text-align: center;"><small><strong>*Campos Obrigatórios</strong></small></div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Perfil</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="perfil" name="perfil" required="required" autofocus>
                            <option value="'.$perfil->getDescricao().'">'.$perfil->getDescricao().'</option>
                            <option value="'.$strLinhaPerfilDescricaoOption.'">'.$strLinhaPerfilDescricaoOption.'</option>
                        </select>
                    </div><br />

                    <label class="col-lg-12 control-label label-usuario">*Nome</label>
                    <input type="text" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" placeholder="*Nome - Máximo 60 caracteres." value="'.$usuario->getNome().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >*Telefone</label>
                    <input type="text" style="width: 320px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" placeholder="*Telefone (xx) x xxxx-xxxx" value="'.$usuario->getFone().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Usuário</label>
                    <input type="text" maxlength="40" style="width: 320px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" placeholder="*Usuário - Máximo 40 caracteres." value="'.$usuario->getUsuario().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Email</label>
                    <input type="email" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="email" name="email" class="form-control" placeholder="*E-mail: nome@provedor.com - máx 60" value="'.$usuario->getEmail().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Senha</label><br />
                    <small>Somente <strong><font color="#FF0000">'.$usuario->getNome().'</font></strong> pode alterar a senha!</small>
                    <input type="password" maxlength="8" style="width: 320px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="********" required disabled><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="view_admin.php?pagina=view_usuarios_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
