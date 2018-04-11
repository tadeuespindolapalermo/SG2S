<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $cursoDao = new CursoDao();
    $curso = new Curso();

    $idCurso = $_GET['idCurso'];

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    $selectCurso = $cursoDao->buscarPorId($conn, $idCurso);
    $linhaCurso = $selectCurso->fetchAll(PDO::FETCH_ASSOC);

    foreach ($linhaCurso as $dados) {
        $curso->setIdCurso($dados['idcurso']);
        $curso->setNome($dados['nome']);
        $curso->setPortaria($dados['portaria']);
        $curso->setDuracao($dados['duracao']);
        $curso->setGrau($dados['grau']);
        $curso->setDataPortaria($dados['data_portaria']);
    }

    echo '
    <div class="container">
        <h4>Atualizar Curso</h4><br />
        <form action="view_admin.php?pagina=../processamento/process_form_curso_update.php&idCurso='.$curso->getIdCurso().'" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="nome" name="nome" class="form-control" value="'.$curso->getNome().'" autofocus required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Portaria</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="portaria" name="portaria" class="form-control" value="'.$curso->getPortaria().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Duração</label>
                    <input type="number" style="width: 300px; margin-bottom: -5px;" id="duracao" name="duracao" class="form-control" value="'.$curso->getDuracao().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Grau</label>
                    <input type="text" style="width: 300px; margin-bottom: -5px;" id="grau" name="grau" class="form-control" value="'.$curso->getGrau().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Data_Portaria</label>
                    <input type="date" style="width: 300px; margin-bottom: -5px;" id="dataPortaria" name="dataPortaria" class="form-control" value="'.$curso->getDataPortaria().'" required><br/>

                    <button type="submit" class="btn btn-success">Atualizar</button><br/><br/>
                </div>
            </div>
        </form>
    </div>';
