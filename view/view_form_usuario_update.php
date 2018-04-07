<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    require('../db/Config.inc.php');

    $idUsuario = $_GET['idUsuario'];

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuarios = new Usuarios();
    $perfil = new Perfil();

    $strSqlUsuario= "
    SELECT
        idusuarios,
        nome,
        fone,
        usuario,
        email,
        senha
    FROM
        usuarios
    WHERE
        idusuarios = :idUsuario";

    $selectUsuario = $conn->prepare($strSqlUsuario);
    $selectUsuario->bindValue(':idUsuario', $idUsuario);
    $selectUsuario->execute();
    $linhaUsuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaUsuario as $dados) {
        $usuarios->setIdUsuarios($dados['idusuarios']);
        $usuarios->setNome($dados['nome']);
        $usuarios->setUsuario($dados['usuario']);
        $usuarios->setEmail($dados['email']);
        $usuarios->setFone($dados['fone']);
        $usuarios->setSenha($dados['senha']);
    }

    $strSqlPerfilUsuario= "
    SELECT
        perfil_idperfil
    FROM
        usuario_perfil
    WHERE
        usuarios_idusuarios = :idUsuario";

    $selectPerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
    $selectPerfilUsuario->bindValue(':idUsuario', $idUsuario);
    $selectPerfilUsuario->execute();
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
        <h4>Atualizar Dados Cadastrais</h4><br />
        <form action="view_admin.php?pagina=../processamento/process_form_usuario_update.php&idUsuario='.$usuarios->getIdUsuarios().'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Perfil</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="perfil" name="perfil" required="required" autofocus>
                            <option value="'.$perfil->getDescricao().'">'.$perfil->getDescricao().'</option>
                            <option value="'.$strLinhaPerfilDescricaoOption.'">'.$strLinhaPerfilDescricaoOption.'</option>
                        </select>
                    </div><br />

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$usuarios->getNome().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$usuarios->getFone().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" value="'.$usuarios->getUsuario().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$usuarios->getEmail().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input type="password" style="width: 300px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="'.$usuarios->getSenha().'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
