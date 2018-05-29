<div class="container listar">
    <div class="header clearfix">
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $disciplina = new Disciplina();
        $disciplinaDao = new DisciplinaDao();

        $idDisciplina = $_GET['idDisciplina'];
    	$disciplina->setIdDisciplina($idDisciplina);

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

        $selectDisciplina = $disciplinaDao->buscarPorId($conn, $idDisciplina);
        $linhaDisciplina = $selectDisciplina->fetchAll(PDO::FETCH_ASSOC);
        foreach ($linhaDisciplina as $dados) {
            $disciplina->setNomeDisciplina($dados['nome_disciplina']);
            $disciplina->setCursoIdCurso($dados['curso_idcurso']);
        }


        $selectDisciplinas = $disciplinaDao->listar($conn);

        ?>
        <br/><br/><br/>
        <h3 style="margin-top: -60px; text-align: center;" class="text-muted">Selecione uma disciplina pré-requisito da disciplina abaixo.</h3><hr /><br/><br/><br/>
        <h3><strong><div style="margin-top: -60px; text-align: center;"><font color="blue"><?php echo $disciplina->getNomeDisciplina();?></font></div></strong></h3><br/>
        <form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_disciplina_pre-requisito.php" id="formDisciplinaPreRequisito"><div style="width: 505px; class="col">

            <?php
            echo '
            <div>
                <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                <div style="margin-left: -5px;"><small><strong>ID Disciplina</strong></small></div>
                <input style="width: 105px; margin-left: -5px;" type="text" class="form-control" id="idDisciplina" name="idDisciplina"
                placeholder="*ID da Disciplina" value="'.$disciplina->getIdDisciplina().'">
            </div>';?>

            <?php
            echo '
            <div>
                <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                <div style="margin-left: -5px;"><small><strong>Curso Disciplina</strong></small></div>
                <input style="width: 105px; margin-left: -5px;" type="text" class="form-control" id="cursoDisciplina" name="cursoDisciplina"
                placeholder="*Curso da Disciplina" value="'.$disciplina->getCursoIdCurso().'">
            </div>';?>

            <?php echo '
            <select class="form-control" id="comboDisciplias" name="comboDisciplinas" required>';
                echo '<option value="">-Selecione a Disciplina-</option>';
                // <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                while ($linhaDisciplinas = $selectDisciplinas->fetchAll(PDO::FETCH_ASSOC)) {
                   foreach ($linhaDisciplinas as $dados) {
                       $disciplina->setIdDisciplina($dados['iddisciplinas']);
                       $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                       $disciplina->setCursoIdCurso($dados['curso_idcurso']);
                       echo '<option value="'.$disciplina->getIdDisciplina().'">'.$disciplina->getNomeDisciplina().'</option>';
                   }
               }
            echo '
            </select><br/>
            <button type="submit" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-primary form-control"><span data-feather="share-2"></span>&nbsp;Associar</button>
            <a href="';?><?php echo $url;?><?php echo '?pagina=view_disciplinas_listagem.php"><button type="button" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-secondary"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
        </form>';
    ?>
