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
        $curso = new Curso();
        $cursoDao = new CursoDao();

        $idCurso = $_GET['idCurso'];
    	$curso->setIdCurso($idCurso);

        $erro_curso = isset($_GET['erro_curso']) ? $_GET['erro_curso'] : 0;
    	$erro_disciplina = isset($_GET['erro_disciplina']) ? $_GET['erro_disciplina'] : 0;

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

        $selectCurso = $cursoDao->buscarPorId($conn, $idCurso);
        $linhaCurso = $selectCurso->fetchAll(PDO::FETCH_ASSOC);
        foreach ($linhaCurso as $dados)
            $curso->setNome($dados['nome']);

        $selectDisciplinas = $disciplinaDao->listar($conn);

        ?>
        <br/><br/><br/>
        <h3 style="margin-top: -60px; text-align: center;" class="text-muted">Selecione uma Disciplina para Associar</h3><hr /><br/><br/><br/>
        <h3><strong><div style="margin-top: -60px; text-align: center;"><font color="blue"><?php echo $curso->getNome();?></font></div></strong></h3><br/>
        <form method="post" action="<?php echo $url;?>?pagina=../controller/controller_form_curso_associar.php" id="formCursoAssociar"><div style="width: 505px; class="col">

            <?php
            echo '
            <div>
                <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                <div style="margin-left: -5px;"><small><strong>ID Curso</strong></small></div>
                <input style="width: 105px; margin-left: -5px;" type="text" class="form-control" id="idCurso" name="idCurso"
                placeholder="*ID do Curso" value="'.$curso->getIdCurso().'">
            </div>';?>

            <?php echo '
            <select class="form-control" id="comboDisciplias" name="comboDisciplinas" required>';
                echo '<option value="">-Selecione a Disciplina-</option>';
                // <div class="col" style="padding: 5px; margin-top: -90px; position:absolute; left:-9999px;">
                while ($linhaDisciplinas = $selectDisciplinas->fetchAll(PDO::FETCH_ASSOC)) {
                   foreach ($linhaDisciplinas as $dados) {
                       $disciplina->setIdDisciplina($dados['iddisciplinas']);
                       $disciplina->setNomeDisciplina($dados['nome_disciplina']);
                       //$disciplina->setCursoIdCurso($dados['curso_idcurso']);
                       echo '<option value="'.$disciplina->getIdDisciplina().'">'.$disciplina->getNomeDisciplina().'</option>';
                   }
               }
            echo '
            </select><br/>';

            if($erro_curso && $erro_disciplina) {
                echo '<font color="#FF0000">Disciplina já está associada ao curso escolhido!</font>';
            }            

            echo '
            <button type="submit" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-primary form-control"><span data-feather="share-2"></span>&nbsp;Associar</button>
            <a href="';?><?php echo $url;?><?php echo '?pagina=view_cursos_listagem.php"><button type="button" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-secondary"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
        </form>';
    ?>
