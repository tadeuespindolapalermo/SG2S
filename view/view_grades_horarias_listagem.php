<!--<div class="container">
    <h1><strong>LISTAGEM DE GRADES HORÁRIAS EM CONSTRUÇÃO...</strong></h1>
</div>--><?php //exit(); ?>
<div class="container listar">
    <div class="header clearfix">
        <h3 class="text-muted">Listagem de Grades Horárias</h3><hr />
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

        // Para listagem sem paginação
        //$selectGradeHoraria = $gradeHorariaDao->listar($conn);

        // Paginação
        // Limita o número de registros a serem mostrados por página
        $limite = 5;

        // Se pg não existe atribui 1 a variável pg
        $pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1;

        // Atribui a variável inicio o inicio de onde os registros vão ser
        // Mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
        $inicio = ($pg * $limite) - $limite;

        $selectGradeHorariaLimite = $gradeHorariaDao->listarLimite($conn, $inicio, $limite);

        $selectGradeHorariaId = $gradeHorariaDao->listarId($conn);
        $resultado = $selectGradeHorariaId->fetchAll(PDO::FETCH_ASSOC);

        // Conta quantos registros tem no banco de dados
        $contadorId =  $selectGradeHorariaId->rowCount(PDO::FETCH_ASSOC);

        // Calcula o total de páginas a serem exibidas
        $qtdPag = ceil($contadorId/$limite);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped listaSearch" id="listaGradesHorarias" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>Sala</th>
                                    <th>Quantidade de Alunos</th>
                                    <th>Turmas</th>
                                    <th>Período do Curso</th>
                                    <th>Dia da Semana</th>
                                    <th>EAD</th>
                                    <th>ID Grade Semestral</th>
                                    <th>Curso</th>
                                    <th>SEGUNDA</th>
                                    <th>TERÇA</th>
                                    <th>QUARTA</th>
                                    <th>QUINTA</th>
                                    <th>SEXTA</th>
                                    <th>SÁBADO</th>
                                    <th>EAD</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <?php
                                while ($linhaGradeHorariaLimite = $selectGradeHorariaLimite->fetchAll(PDO::FETCH_ASSOC)) {
                                    foreach ($linhaGradeHorariaLimite as $dados) {

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
                                        $gradeHoraria->setDsSeg($dados['dsSeg']);
                                        $gradeHoraria->setDsTer($dados['dsTer']);
                                        $gradeHoraria->setDsQua($dados['dsQua']);
                                        $gradeHoraria->setDsQui($dados['dsQui']);
                                        $gradeHoraria->setDsSex($dados['dsSex']);
                                        $gradeHoraria->setDsSab($dados['dsSab']);
                                        $gradeHoraria->setDsEad($dados['dsEad']);

                                        if ($_SESSION['perfil_idperfil'] == 1) {
                                            $alert = 'msgConfirmaDeleteGradeHorariaAdmin('.$gradeHoraria->getIdGradeHoraria().')';
                                        } elseif ($_SESSION['perfil_idperfil'] == 2) {
                                            $alert = 'msgConfirmaDeleteGradeHorariaCoordenador('.$gradeHoraria->getIdGradeHoraria().')';
                                        }

                                        // TRATAMENTO DO CAMPO EAD (APENAS VISUALIZAÇÃO)
                                        $eadListagem = "";
                                        if($gradeHoraria->getEad() == 0) {
                                            $eadListagem = "NÃO";
                                        } else {
                                            $eadListagem = "SIM";
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
                                            <tr>
                                                <td>'.$gradeHoraria->getSala().'</td>
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
                                                <td><a href="';?><?php echo $url;?><?php echo '?pagina=view_form_grade_horaria_update.php&idGradeHoraria='.$gradeHoraria->getIdGradeHoraria().'"><img src="../lib/open-iconic/svg/brush.svg" alt="editar"></a></td>
                                            </tr>
                                        </tbody>';
                                    }
                                }
                            ?>
                        </table>
                        <?php
                            // Navegação da tabela pela paginação
                            echo '<div style="text-align: center;">';
                                echo '<ul class="pagination justify-content-center">';
                                    if ($pg <= 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_horarias_listagem.php&pg=1">Início</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_horarias_listagem.php&pg=1">Início</a></li>&nbsp';
                                    }
                                    if($qtdPag > 1 && $pg <= $qtdPag) {
                                        for($i = 1; $i <= $qtdPag; $i++) {
                                            if ($i == $pg) {
                                                echo "<li class='page-item'><a class='page-link'><strong>".$i."</strong></a></li>&nbsp";
                                            } else {
                                                echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_horarias_listagem.php&pg='.$i.'">'.$i.'</a></li>&nbsp';
                                            }
                                        }
                                    }
                                    if($pg == $qtdPag || $qtdPag == 0) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_horarias_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="';?><?php echo $url;?><?php echo '?pagina=view_grades_horarias_listagem.php&pg='.$qtdPag.'">Final</a></li>&nbsp';
                                    }
                                echo '</ul>';
                                echo '<small>Listando até 5 registros por página.</small>';
                            echo '</div>';
                        ?>
                        <br/>
                        <button export-to-excel="listaGradesHorarias" class="btn btn-success">
                            <span data-feather="download"></span>&nbsp;Excel
                        </button>
                        <!--<button type="button" onclick="javascript:iniciaRequisitaAjax('GET','nome_da_pagina.php','true');" class="btn btn-dark"><span data-feather="layers"></span>&nbsp;Nome da Funcionalidade</button>-->
                        <button id="btnSearch" onclick="alterarDisabledSearch()" class="btn btn-outline-dark"><span data-feather="search"></span>&nbsp;Busca</button>
                    </div><br /><hr>
                    <!-- DIV para usar requisição Ajax-->
                    <!--<div id="conteudo"></div>-->
                </div>
            </div>
        </div>
    </div>
</div>
