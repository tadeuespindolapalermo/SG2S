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
        usuario,
        email,
        senha
    FROM
        usuarios
    WHERE
        idusuarios=".$_GET['idUsuario'];

    $rs = $objConexao->executarConsulta($link, $strSql);

    $linha = mysqli_fetch_array($rs, MYSQLI_ASSOC);

    echo '
    <div class="container">
        <h4>Atualizar Dados Cadastrais</h4><br />
        <form action="admin.php?pagina=../processamento/usuarios_update.php&idUsuario='.$linha['idusuarios'].'" method="post">
            <div class="form-group ">
                <div class="col-lg-13">
                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$linha['nome'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$linha['fone'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="usuario" name="usuario" class="form-control" value="'.$linha['usuario'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$linha['email'].'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
