<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $professorDao = new ProfessorDao();
    $professor = new Professor();

    $idProfessor = $_GET['idProfessor'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
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
        <h4>Atualizar Professor</h4><br />
        <form action="view_admin.php?pagina=../controller/controller_form_professor_update.php&idProfessor='.$professor->getIdProfessor().'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$professor->getNome().'" autofocus required><br/>

                    <label class="col-lg-2 control-label label-usuario" >CPF</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="cpf" name="cpf" class="form-control" value="'.$professor->getCPF().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">RG</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="rg" name="rg" class="form-control" value="'.$professor->getRG().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Email</label>
                    <input type="email" style="width: 300px; margin-bottom: -5px;" id="email" name="email" class="form-control" value="'.$professor->getEmail().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Telefone</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="telefone" name="telefone" class="form-control" value="'.$professor->getFone().'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
