<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Selecione uma Grade Semestral para Visualizar</h3><hr />
    </div>

    <?php
        session_start();
        ob_start();
        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $gradeHoraria = new GradeHoraria();
        $gradeHorariaDao = new GradeHorariaDao();

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

        $selectGradesSemestrais =  $gradeHorariaDao->listarGradesSemestrais($conn);

        ?>
        <form method="post" action="<?php echo $url;?>?pagina=view_grades_horarias_listagem.php" id="formGradeHoraria">        <div style="width: 505px; class="col">
            <?php echo '
            <select class="form-control" id="comboGradeSemestral" name="comboGradeSemestral" required>';
                echo '<option value="">-Selecione a Grade Semestral-</option>';
                while ($linhaGradesSemestraisCombo = $selectGradesSemestrais->fetchAll(PDO::FETCH_ASSOC)) {
                   foreach ($linhaGradesSemestraisCombo as $dados) {
                       $gradeHoraria->setGradeSemestralAno($dados['ano_letivo']);
                       $gradeHoraria->setGradeSemestralCurso($dados['nome']);
                       $gradeHoraria->setGradeSemestralSemestre($dados['semestre_letivo']);
                       $gradeHoraria->setGradeSemestralId($dados['idgrade_semestral']);
                       echo '<option value="'.$gradeHoraria->getGradeSemestralId().'">'.$gradeHoraria->getGradeSemestralAno().'.'.$gradeHoraria->getGradeSemestralSemestre().' - '.$gradeHoraria->getGradeSemestralCurso().'</option>';
                   }
               }
            echo '
            </select><br/>
            <button type="submit" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-success form-control"><span data-feather="search"></span>&nbsp;Buscar</button>
            <a href="';?><?php echo $url;?><?php echo '?pagina=view_grades_semestrais_listagem.php"><button type="button" style="margin-bottom: 5px; width: 250px;" class="btn btn-outline-secondary"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
        </form>';
    ?>
