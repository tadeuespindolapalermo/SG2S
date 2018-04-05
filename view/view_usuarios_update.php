<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/sair.php');
    }

    require('../db/Config.inc.php');

    $idUsuario = $_GET['idUsuario'];

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

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
        $idusuarios = $dados['idusuarios'];
        $nome = $dados['nome'];
        $usuario = $dados['usuario'];
        $email = $dados['email'];
        $fone = $dados['fone'];
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
        $idusuario_perfil = $dados['perfil_idperfil'];

    if($idusuario_perfil == 1) {
        $strLinhaPerfilUsuario = "Administrador";
        $strLinhaPerfilUsuarioOption = "Coordenador";
    } elseif ($idusuario_perfil == 2) {
        $strLinhaPerfilUsuario = "Coordenador";
        $strLinhaPerfilUsuarioOption = "Administrador";
    }

    echo '
    <div class="container">
        <h4>Atualizar Dados Cadastrais</h4><br />
        <form action="admin.php?pagina=../processamento/usuarios_update.php&idUsuario='.$idusuarios.'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Perfil</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="perfil" name="perfil" required="required" autofocus>
                            <option value="'.$strLinhaPerfilUsuario.'">'.$strLinhaPerfilUsuario.'</option>
                            <option value="'.$strLinhaPerfilUsuarioOption.'">'.$strLinhaPerfilUsuarioOption.'</option>
                        </select>
                    </div><br />

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$nome.'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$fone.'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" value="'.$usuario.'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$email.'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input type="password" style="width: 300px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="'.$_SESSION['senha'].'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
