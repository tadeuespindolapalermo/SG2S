<?php

    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();   
        header('Location: ../processamento/sair.php');
    }

    require_once('../db/Conexao.class.php');

    $usuarioSessao = $_SESSION['usuario'];

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

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
        idusuarios=".$_GET['idUsuario'];

    $strSqlPerfilUsuario= "
    SELECT
        idusuario_perfil,
        usuarios_idusuarios,
        perfil_idperfil
    FROM
        usuario_perfil
    WHERE
        usuarios_idusuarios=".$_GET['idUsuario'];

    $rsUsuario = $objConexao->executarConsulta($link, $strSqlUsuario);
    $rsPerfilUsuario = $objConexao->executarConsulta($link, $strSqlPerfilUsuario);

    $linhaUsuario = mysqli_fetch_array($rsUsuario, MYSQLI_ASSOC);
    $linhaPerfilUsuario = mysqli_fetch_array($rsPerfilUsuario, MYSQLI_ASSOC);

    if($linhaPerfilUsuario['perfil_idperfil'] == 1) {
        $strLinhaPerfilUsuario = "Administrador";
        $strLinhaPerfilUsuarioOption = "Coordenador";
    } elseif ($linhaPerfilUsuario['perfil_idperfil'] == 2) {
        $strLinhaPerfilUsuario = "Coordenador";
        $strLinhaPerfilUsuarioOption = "Administrador";
    }

    echo '
    <div class="container">
        <h4>Atualizar Dados Cadastrais</h4><br />
        <form action="admin.php?pagina=../processamento/usuarios_update.php&idUsuario='.$linhaUsuario['idusuarios'].'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Perfil</label>
                    <div class="form-group" style="width: 300px; margin-bottom: -5px;">
                        <select class="form-control" id="perfil" name="perfil" required="required">
                            <option value="'.$strLinhaPerfilUsuario.'">'.$strLinhaPerfilUsuario.'</option>
                            <option value="'.$strLinhaPerfilUsuarioOption.'">'.$strLinhaPerfilUsuarioOption.'</option>
                        </select>
                    </div><br />

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$linhaUsuario['nome'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$linhaUsuario['fone'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" value="'.$linhaUsuario['usuario'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$linhaUsuario['email'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input type="password" style="width: 300px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="'.$_SESSION['senha'].'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
