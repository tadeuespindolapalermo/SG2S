<?php

    session_start();

    require_once('../db/Conexao.class.php');

    $idUsuarioSessao = $_SESSION['idusuarios'];

    $objConexao = new Conexao();
    $link = $objConexao->conectar();

    $erro_update = isset($_GET['erro_update']) ? $_GET['erro_update'] : 0;

    $strSql= "
    SELECT        
        nome,
        fone,
        usuario,
        email,
        senha
    FROM
        usuarios
    WHERE
        idusuarios='{$idUsuarioSessao}'";

    $rs = $objConexao->executarConsulta($link, $strSql);

    $linha = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    if($erro_update) {
        echo '<div style="margin-left: 18px;"><font color="#FF0000"><strong>Erro ao atualizar! Modifique algum dado no formulário!</strong></font></div>';
    }
    echo '
    <div class="container">
        <h3 class="text-muted">Atualizar Dados Cadastrais</h3>
        <form action="../processamento/usuario_logado_update.php" method="post">
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

                    <label class="col-lg-2 control-label label-usuario">Senha</label>
                    <input type="password" style="width: 300px; margin-bottom: -5px;" id="senha" name="senha" class="form-control" value="'.$_SESSION['senha'].'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
