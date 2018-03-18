<?php

    session_start();

    require_once('../db/Conexao.class.php');

    $usuarioSessao = $_SESSION['usuario'];

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $strSql= "
    SELECT
        id,
        nome,
        sobrenome,
        usuario,
        email,
        senha
    FROM
        usuarios
    WHERE
        usuario='{$usuarioSessao}'";

    $rs = $objConexao->executarConsulta($link, $strSql);

    $linha = mysqli_fetch_array($rs, MYSQLI_ASSOC);

    echo '
    <div class="container">
        <h3>Editar Usuário</h3><br />
        <form action="../processamento/usuario_update.php" method="post">
            <div class="form-group ">
                <div class="col-lg-13">
                    <label class="col-lg-12 control-label label-usuario">Id</label>
                    <input style="width: 55px; margin-bottom: -5px;" name="id" class="form-control" value="'.$linha['id'].'" disabled><br/>

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input style="width: 300px; margin-bottom: -5px;" name="nome" class="form-control" value="'.$linha['nome'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Sobrenome</label>
                    <input style="width: 300px; margin-bottom: -5px;" name="sobrenome" class="form-control" value="'.$linha['sobrenome'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Usuário</label>
                    <input style="width: 300px; margin-bottom: -5px;" name="usuario" class="form-control" value="'.$linha['usuario'].'" required disabled><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input style="width: 300px; margin-bottom: -5px;" name="email" class="form-control" value="'.$linha['email'].'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input style="width: 300px; margin-bottom: -5px;" name="senha" class="form-control" value="'.$_SESSION['senha'].'"><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
