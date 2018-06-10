<!--<div class="container">
    <h1><strong>LISTAGEM DE GRADES HORÁRIAS EM CONSTRUÇÃO...</strong></h1>
</div>--><?php //exit(); ?>
<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted" style="text-align: center">FACULDADE JK SANTA MARIA</h3><hr />
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

        $gradeHoraria->setGradeSemestralId($_POST['comboGradeSemestral']);

        /*echo $gradeHoraria->getGradeSemestralId();
        exit();*/

        $idGradeSemestral = $gradeHoraria->getGradeSemestralId();
        $selectPorGradeSemestral = $gradeHorariaDao->listarPorGradeSemestral($conn, $idGradeSemestral);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table-hover table-striped listaSearch" id="listarGradesHorarias" style="text-align: center;">
                            <thead>
                                <tr>
                                    <!--<th>Sala</th>
                                    <th>Quantidade de Alunos</th>
                                    <th>Turmas</th>
                                    <th>Período do Curso</th>
                                    <th>Dia da Semana</th>
                                    <th>EAD</th>
                                    <th>ID Grade Semestral</th>
                                    <th>CURSO</th>
                                    <th>SEGUNDA</th>
                                    <th>TERÇA</th>
                                    <th>QUARTA</th>
                                    <th>QUINTA</th>
                                    <th>SEXTA</th>
                                    <th>SÁBADO</th>
                                    <th>EAD</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>-->

                                    <th>Semestre<br/>Turma</th>
                                    <th>Quantidade<br/>Alunos</th>
                                    <th>Sala</th>
                                    <th>SEGUNDA</th>
                                    <th>TERÇA</th>
                                    <th>QUARTA</th>
                                    <th>QUINTA</th>
                                    <th>SEXTA</th>
                                    <th>SÁBADO</th>
                                    <th>EAD 1</th>
                                    <th>EAD 2</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                //while ($linhaGradeHorariaLimite = $selectGradeHorariaLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                while ($linhaGradeSemestral = $selectPorGradeSemestral->fetchAll(PDO::FETCH_ASSOC)) {
                                    //foreach ($linhaGradeHorariaLimite as $dados) {
                                    foreach ($linhaGradeSemestral as $dados) {

                                        $gradeHoraria->setIdGradeHoraria($dados['idgrade_horaria']);
                                        $gradeHoraria->setSala($dados['sala']);
                                        $gradeHoraria->setQuantidadeAlunos($dados['quantidade_alunos']);
                                        $gradeHoraria->setTurmas($dados['turmas']);
                                        $gradeHoraria->setPeriodoCurso($dados['periodo_curso']);
                                        $gradeHoraria->setDiaSemana($dados['dia_semana']);
                                        $gradeHoraria->setEad($dados['ead']);
                                        $gradeHoraria->setIdGradeSemestral($dados['grade_semestral_idgrade_semestral']);
                                        $gradeHoraria->setIdCursoGradeSemestral($dados['grade_semestral_curso_idcurso']);
                                        $gradeHoraria->setCursoNome($dados['nome']);
                                        $gradeHoraria->setCursoGrau($dados['grau']);
                                        $gradeHoraria->setGradeSemestralSemestre($dados['semestre_letivo']);
                                        $gradeHoraria->setGradeSemestralAno($dados['ano_letivo']);
                                        $gradeHoraria->setGradeSemestralHorario($dados['horario']);
                                        $gradeHoraria->setDsSeg($dados['dsSeg']);
                                        $gradeHoraria->setDsTer($dados['dsTer']);
                                        $gradeHoraria->setDsQua($dados['dsQua']);
                                        $gradeHoraria->setDsQui($dados['dsQui']);
                                        $gradeHoraria->setDsSex($dados['dsSex']);
                                        $gradeHoraria->setDsSab($dados['dsSab']);
                                        $gradeHoraria->setDsEad1($dados['dsEad1']);
                                        $gradeHoraria->setDsEad2($dados['dsEad2']);
                                        $gradeHoraria->setDsSegProf($dados['dsSegProf']);
                                        $gradeHoraria->setDsTerProf($dados['dsTerProf']);
                                        $gradeHoraria->setDsQuaProf($dados['dsQuaProf']);
                                        $gradeHoraria->setDsQuiProf($dados['dsQuiProf']);
                                        $gradeHoraria->setDsSexProf($dados['dsSexProf']);
                                        $gradeHoraria->setDsSabProf($dados['dsSabProf']);
                                        $gradeHoraria->setDsEad1Prof($dados['dsEad1Prof']);
                                        $gradeHoraria->setDsEad2Prof($dados['dsEad2Prof']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteGradeHorariaAdmin('.$gradeHoraria->getIdGradeHoraria().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteGradeHorariaCoordenador('.$gradeHoraria->getIdGradeHoraria().')';
                                        }

                                        // TRATAMENTO DO CAMPO EAD (APENAS VISUALIZAÇÃO)
                                        /*$eadListagem = "";
                                        if($gradeHoraria->getEad() == 0 || ($gradeHoraria->getDsEad1() == "" && $gradeHoraria->getDsEad2() == "")
                                            || ($gradeHoraria->getDsEad1() == "" || $gradeHoraria->getDsEad2() == "")) {
                                            $eadListagem = "NÃO";
                                            $professor = "";
                                        } else {
                                            $eadListagem = "SIM";
                                            $professor = "Professor:";
                                        }*/

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE SÁBADO (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsSab() == "") {
                                            $salaSab = "";
                                            $numSalaSab = "";
                                        } else {
                                            $salaSab = "Sala: ";
                                            $numSalaSab = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE SEXTA (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsSex() == "") {
                                            $salaSex = "";
                                            $numSalaSex = "";
                                        } else {
                                            $salaSex = "Sala: ";
                                            $numSalaSex = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE QUINTA (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsQui() == "") {
                                            $salaQui = "";
                                            $numSalaQui = "";
                                        } else {
                                            $salaQui = "Sala: ";
                                            $numSalaQui = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE QUARTA (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsQua() == "") {
                                            $salaQua = "";
                                            $numSalaQua = "";
                                        } else {
                                            $salaQua = "Sala: ";
                                            $numSalaQua = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE TERÇA (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsTer() == "") {
                                            $salaTer = "";
                                            $numSalaTer = "";
                                        } else {
                                            $salaTer = "Sala: ";
                                            $numSalaTer = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO SALA PARA DISCIPLINA DE SEGUNDA (APENAS VISUALIZAÇÃO)
                                        if ($gradeHoraria->getDsSeg() == "") {
                                            $salaSeg = "";
                                            $numSalaSeg = "";
                                        } else {
                                            $salaSeg = "Sala: ";
                                            $numSalaSeg = $gradeHoraria->getSala();
                                        }

                                        // TRATAMENTO DO CAMPO DIA DA SEMANA (APENAS VISUALIZAÇÃO)
                                        $diaSemanaListagem = "";
                                        switch($gradeHoraria->getDiaSemana()) {
                                            case 1:
                                                $diaSemanaListagem = "Domingo";
                                                break;
                                            case 2:
                                                $diaSemanaListagem = "Segunda-feira";
                                                break;
                                            case 3:
                                                $diaSemanaListagem = "Terça-feira";
                                                break;
                                            case 4:
                                                $diaSemanaListagem = "Quarta-feira";
                                                break;
                                            case 5:
                                                $diaSemanaListagem = "Quinta-fera";
                                                break;
                                            case 6:
                                                $diaSemanaListagem = "Sexta-feira";
                                                break;
                                            case 7:
                                                $diaSemanaListagem = "Sábado";
                                                break;
                                            default:
                                                $diaSemanaListagem = "";
                                                break;
                                        }
                                        echo '
                                        <tbody>
                                            <tr>';
                                                /*<td>'.$gradeHoraria->getSala().'</td>
                                                <td>'.$gradeHoraria->getQuantidadeAlunos().'</td>
                                                <td>'.$gradeHoraria->getTurmas().'</td>
                                                <td>'.$gradeHoraria->getPeriodoCurso().'º Semestre</td>
                                                <td>'.$diaSemanaListagem.'</td>
                                                <td>'.$eadListagem.'</td>
                                                <td>'.$gradeHoraria->getIdGradeSemestral().'</td>
                                                <td>'.$gradeHoraria->getCursoNome().'</td>
                                                <td>'.$gradeHoraria->getDsSeg().'</td>
                                                <td>'.$gradeHoraria->getDsTer().'</td>
                                                <td>'.$gradeHoraria->getDsQua().'</td>
                                                <td>'.$gradeHoraria->getDsQui().'</td>
                                                <td>'.$gradeHoraria->getDsSex().'</td>
                                                <td>'.$gradeHoraria->getDsSab().'</td>
                                                <td>'.$gradeHoraria->getDsEad().'</td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_grade_horaria_update.php&idGradeHoraria='.$gradeHoraria->getIdGradeHoraria().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>*/
                                            echo '
                                                <td>'.$gradeHoraria->getTurmas().'</td>
                                                <td>'.$gradeHoraria->getQuantidadeAlunos().'</td>
                                                <td>'.$gradeHoraria->getSala().'</td>
                                                <td>'.$gradeHoraria->getDsSeg().'<br/><small>'.$salaSeg.'<strong>'.$numSalaSeg.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsTer().'<br/><small>'.$salaTer.'<strong>'.$numSalaTer.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsQua().'<br/><small>'.$salaQua.'<strong>'.$numSalaQua.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsQui().'<br/><small>'.$salaQui.'<strong>'.$numSalaQui.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsSex().'<br/><small>'.$salaSex.'<strong>'.$numSalaSex.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsSab().'<br/><small>'.$salaSab.'<strong>'.$numSalaSab.'</strong></small></td>
                                                <td>'.$gradeHoraria->getDsEad1().'</td>
                                                <td>'.$gradeHoraria->getDsEad2().'</td>
                                                <td><a href="javascript:void(null);" onclick="'.$alert.'"><img src="../lib/open-iconic/svg/x.svg" alt="remover"></a></td>
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_grade_horaria_update.php&idGradeHoraria='.$gradeHoraria->getIdGradeHoraria().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                                echo '
                                <div style="text-align: center; font-weight: 900; font-size: 18px;">
                                    GRADE HORÁRIA: '.strtoupper($gradeHoraria->getCursoGrau()).' EM '.strtoupper($gradeHoraria->getCursoNome()).' - '.$gradeHoraria->getGradeSemestralSemestre().'º SEMESTRE DE '.$gradeHoraria->getGradeSemestralAno().'<br/>
                                    PERÍODO: '.$gradeHoraria->getGradeSemestralHorario().'</br><br/>
                                </div>
                                ';
                            ?>
                        </table>
                        <br/>
                        <button export-to-excel-grade-horaria="listarGradesHorarias" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <!--<button type="button" onclick="javascript:iniciaRequisitaAjax('GET','nome_da_pagina.php','true');" class="btn btn-dark"><span data-feather="layers"></span>&nbsp;Nome da Funcionalidade</button>-->
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                        <a href="<?php echo $url;?>?pagina=view_form_grade_semestral_selecionar.php"><button type="button" class="btn btn-outline-secondary"><span data-feather="arrow-left"></span>&nbsp;Voltar</button></a>
                    </div><br /><hr>
                    <!-- DIV para usar requisição Ajax-->
                    <!--<div id="conteudo"></div>-->
                </div>
            </div>
        </div>
    </div>
</div>
