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
        header('Location: ../controller/controller_sair.php');
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

    // VERIFICAÇÕES DO COMBO BOX GRAU
    if ($curso->getGrau() == 'Tecnólogo') {
        $grauUmOption = 'Bacharelado';
        $grauDoisOption = 'Licenciatura';
    } elseif ($curso->getGrau() == 'Bacharelado') {
        $grauUmOption = 'Tecnólogo';
        $grauDoisOption = 'Licenciatura';
    } elseif ($curso->getGrau() == 'Licenciatura') {
        $grauUmOption = 'Bacharelado';
        $grauDoisOption = 'Tecnólogo';
    }

    echo '
    <div class="container">
        <div class="col-md-4">
            <h4><strong>Atualização Cadastral</strong></h4>
            <div style="margin-left: px;"><h5><strong><font color="#FF0000">'.strtoupper($curso->getNome()).'.</font><strong></h5></div><br />
            <form action="view_admin.php?pagina=../controller/controller_form_curso_update.php&idCurso='.$curso->getIdCurso().'" method="post">
                <div class="form-group ">

                    <label class="col-lg-12 control-label label-usuario">Nome</label>
                    <input type="text" maxlength="60" style="width: 320px; margin-bottom: -5px;" id="nome" name="nome" placeholder="*Nome - Até 60 caracteres." class="form-control" value="'.$curso->getNome().'" autofocus required><br/>

                    <label class="col-lg-2 control-label label-usuario" >Portaria</label>
                    <input type="text" maxlength="30" style="width: 320px; margin-bottom: -5px;" id="portaria" name="portaria" placeholder="*Portaria - Até 30 caracteres." class="form-control" value="'.$curso->getPortaria().'" required><br/>

                    <label class="col-lg-2 control-label label-usuario">Duração</label>
                    <input type="number" min="0.5" max="8.0" step="0.5" style="width: 320px; margin-bottom: -5px;" id="duracao" name="duracao" class="form-control" placeholder="*Duração (Anos) - Entre 0.5 à 8.0" value="'.$curso->getDuracao().'" required><br/>

                    <label class="col-lg-12 control-label label-usuario">Grau</label>
                    <div class="form-group" style="width: 320px; margin-bottom: -5px;">
                        <select class="form-control" id="grau" name="grau" required="required">
                            <option value="'.$curso->getGrau().'">'.$curso->getGrau().'</option>
                            <option value="'.$grauUmOption.'">'.$grauUmOption.'</option>
                            <option value="'.$grauDoisOption.'">'.$grauDoisOption.'</option>
                        </select>
                    </div><br />

                    <label class="col-lg-2 control-label label-usuario">Data_Portaria</label>
                    <input type="date" style="width: 320px; margin-bottom: -5px;" id="dataPortaria" name="dataPortaria" class="form-control" placeholder="*Data Portaria: dd/mm/YYYY" value="'.$curso->getDataPortaria().'" required><br/>

                    <button type="submit" style="margin-bottom: 5px;" class="btn btn-outline-primary form-control">Atualizar</button><br/>
                    <button id="btnVoltarInicio" type="button" onclick="voltarInicio()" class="btn btn-outline-secondary form-control">Voltar Início</button>
                </div>
            </form>
        </div>
    </div>';
