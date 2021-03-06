<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professorDao = new ProfessorDao();
    $professor = new Professor();

    $idProfessor = $_GET['idProfessor'];

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    if ($_SESSION['perfil_idperfil'] == 1) {
        $url = 'view_admin.php';
    } elseif ($_SESSION['perfil_idperfil'] == 2) {
        $url = 'view_coordenador.php';
    }

    $selectProfessor = $professorDao->buscarPorId($conn, $idProfessor);
    $linhaProfessor = $selectProfessor->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaProfessor as $dados) {
        $professor->setIdProfessor($dados['idprofessor']);
        $professor->setNome($dados['nome']);
        $professor->setCPF($dados['CPF']);
        $professor->setRG($dados['RG']);
        $professor->setEmail($dados['email']);
        $professor->setFone($dados['fone']);
    }

    echo '
    <div class="container">
            <div class="col-md-4">
            <div style="text-align: center;"><h4><strong>Atualizar Professor</strong></h4></div>
            <div style="text-align: center;"><h5><strong><font color="#FF0000">'.strtoupper($professor->getNome()).'</font><strong></h5></div>
            <form action="';?><?php echo $url;?><?php echo '?pagina=../controller/controller_form_professor_update.php&idProfessor='.$professor->getIdProfessor().'" method="post">
                <div class="form-group ">

                    <div style="text-align: center;"><small><strong>*Campos Obrigatórios</strong></small></div><br/>

                    <label class="col-lg-12 control-label label-usuario">*Nome</label>
                    <input type="text" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="nome" name="nome" placeholder="*Nome - Até 60 caracteres." class="form-control" value="'.$professor->getNome().'" autofocus required><br/>

                    <label class="col-lg-2 control-label label-usuario" >*CPF</label>
                    <input type="text" style="width: 320px; margin-bottom: -5px;" id="cpf" name="cpf" class="form-control" placeholder="*CPF: 999.999.999-99" value="'.$professor->getCPF().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*RG</label>
                    <input type="text" min="0" style="width: 320px; margin-bottom: -5px;" id="rg" name="rg" class="form-control" placeholder="*RG - Apenas números." value="'.$professor->getRG().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Email</label>
                    <input type="email" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="email" name="email" class="form-control" placeholder="*E-mail: nome@provedor.com - máx 60" value="'.$professor->getEmail().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">*Telefone</label>
                    <input type="text" style="width: 320px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" placeholder="*Telefone (xx) x xxxx-xxxx" value="'.$professor->getFone().'" required><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-primary form-control"><span data-feather="save"></span>&nbsp;Atualizar</button>
                    <a href="';?><?php echo $url;?><?php echo '?pagina=view_professores_listagem.php"><button type="button" class="btn btn-outline-secondary form-control"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                </div>
            </form>
        </div>
    </div>';
