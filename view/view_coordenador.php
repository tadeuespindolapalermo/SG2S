<?php
    session_start();
    ob_start();
    // TEMPO DE SESSÃO DO USUÁRIO (30 MINUTOS) INDEPENDENTE DE OCIOSIDADE - FORÇADA
    //if (!isset($_SESSION['start_login'])) { // se não tiver pego tempo que logou
        //$_SESSION['start_login'] = time(); //pega tempo que logou
        // adiciona 30 minutos ao tempo e grava em outra variável de sessão
        //$_SESSION['logout_time'] = $_SESSION['start_login'] + 30 * 60;
    //}
    // ---------------------------------------------------------

    if (!isset($_SESSION['usuario'])) {
        header('Location: ../index.php?erro=1');
    }

    if($_SESSION['perfil_idperfil'] == 1) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    } else {
        $perfil = 'Coordenador';
    }
?>

<!DOCTYPE html>
<html lang="pt-br" ng-app="sg2s">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="SG2S - Sistema de Geração da Grade Semestral" />
        <meta name="author" content="Tadeu Espíndola Palermo | Marcos Alexandre da Silva" />
        <link rel="shortcut icon" type="image/x-icon" href="../img/favicon/favicon.ico" />

        <title>SG2S - Sistema de Geração da Grade Semestral</title>

        <!-- Bootstrap 4 core CSS -->
        <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="../css/dashboard.css" rel="stylesheet" />

        <!-- Estilos gerais -->
        <link href="../css/estilo.css" rel="stylesheet" />

        <!-- Tabela Personalizada para SEARCH -->
        <link href="../css/tableSearch.css" rel="stylesheet" />

        <!-- jquery 1.3.2 sem cdn, fixo no código-->
		<script src="../lib/jquery/jquery-1_3_2.min.js"></script>
		<!-- jquery 1.3.2 - link cdn-->
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>-->

		<!-- Maskedinput do jQuery-->
		<script src="../lib/jquery/maskedinput.js"></script>

		<!-- Máscaras dos campos de formulários-->
		<script src="../lib/jquery/masks.js"></script>
        <script src="../js/dom.js"></script>
        <script src="../js/alerts.js"></script>
    </head>

    <body>

        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
            <span class="navbar-brand col-sm-3 col-md-2 mr-0"><strong>SG2S - <?php echo $perfil; ?></strong></span>
            <!--<input type="text" class="input-search" alt="listaSearch" placeholder="Pesquisa rápida..." />-->
            <input id="searchListagens" style="border: 1px solid grey; border-radius: 4px;" class="form-control form-control-dark w-100 input-search" alt="listaSearch" type="text" placeholder="Pesquisa rápida..." disabled aria-label="Pesquisa rápida..." />
            <!--<ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="../controller/controller_sair.php">Sair</a>
                </li>
            </ul>-->
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="view_coordenador.php?pagina=view_home.php">
                                    <span data-feather="home"></span>
                                    Início <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_coordenador.php?pagina=view_form_usuario_logado_update.php">
                                    <span data-feather="settings"></span>
                                    <strong>
                                        <?php
                                            $nome = $_SESSION['nome'];
                                            $nome = explode(" ", $nome);
                                            echo "$nome[0]";
                                        ?>
                                    </strong>
                                </a>
                            </li>
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span>CADASTROS</span>
                            </h6>
                            <li class="nav-item">
                                <a class="nav-link" href="view_coordenador.php?pagina=view_grades_semestrais_listagem.php">
                                    <span data-feather="grid"></span>
                                    Grade Semestral
                                </a>
                            </li>
                            <span class="nav-item">
                                <span style="margin-left: 16px;" href="">
                                    <span data-feather="alert-triangle"></span>
                                    <font color="gray"><span style="margin-left: 4px;">Grade de Aluno<span></font><br/>
                                    <small style="margin-left: 42px;"><strong><font color="red">Implementação futura!</font></strong></small>
                                </span>
                            </span>
                            <li class="nav-item">
                                <a class="nav-link" href="view_coordenador.php?pagina=view_cursos_listagem.php">
                                    <span data-feather="layers"></span>
                                    Cursos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_coordenador.php?pagina=view_disciplinas_listagem.php">
                                    <span data-feather="edit-2"></span>
                                    Disciplinas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_coordenador.php?pagina=view_professores_listagem.php">
                                    <span data-feather="user"></span>
                                    Professor
                                </a>
                            </li>
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                <span>UTILITÁRIOS</span>
                            </h6>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="bar-chart-2"></span>
                                    Relatórios
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Histório de Grades</span>
                            <a class="d-flex align-items-center text-muted" href="#">
                                <span data-feather="plus-circle"></span>
                            </a>
                        </h6>

                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                  <span data-feather="tag"></span>
                                  1.2018
                                </a>
                            </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">
                                  <span data-feather="tag"></span>
                                  2.2018
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">
                                  <span data-feather="tag"></span>
                                  1.2019
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">
                                  <span data-feather="tag"></span>
                                  2.2019
                                  <hr />
                              </a>
                          </li>
                          <li><img class="logo-jk" src="../img/logo-jk.png" alt="Faculdade JK" /></li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Sistema de Geração da Grade Semestral</h1>
                        <?php
                            echo "<div style='margin-left: 200px;'><span style='font-weight: 900; font-size: 18px;'>Data: " . date('d-m-Y') . "</span></div>";
                            // CÓDIGO PARA UTILIZAÇÃO DE TEMPO DE SESSÃO FORÇADA
                            // se o tempo atual for maior que o tempo de logout
                            //if(time() >= $_SESSION['logout_time']) {
                                //unset($_SESSION['usuario']);
                                //unset($_SESSION['email']);
                                //session_destroy();
                                //header('Location: ../#!/index'); //vai para logout
                            //} else {
                                //$red = $_SESSION['logout_time'] - time(); // tempo que falta
                                //echo "Início de sessão: ".$_SESSION['start_login']."<br>";
                                //echo "Redirecionando em ".$red." segundos.<br>";
                            //}
                        ?>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <!--<button class="btn btn-sm btn-outline-secondary"><i>Compartilhar</i></button>-->
                                <a href="../controller/controller_sair.php"><button class="btn btn-sm btn-outline-secondary">
                                    <i><img src="../lib/open-iconic/svg/power-standby.svg" alt="sair"></i>&nbsp;Sair
                                </button></a>
                                <!--<button class="btn btn-sm btn-outline-secondary">Exportar</button>-->
                            </div>
                            <!--<button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="activity"></span>
                                Atividades
                            </button>-->
                        </div>
                    </div>

                    <?php
                        include_once('boas-vindas.php');
                        require_once($_GET["pagina"]);
                     ?>

                </main>
            </div>
        </div>

        <?php
            if (isset($_GET["pagina"])) {
                echo '<hr/>';
                include_once $_GET["pagina"];
            }
        ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <!-- jquery 3.2.1 com cdn -->
        <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->

        <!-- jquery 3.2.1 sem cdn -->
        <script src="../lib/jquery/jquery-3_2_1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <!-- jquery 1.9.1 com cdn -->
        <!--<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->

        <!-- jquery 1.9.1 sem cdn -->
        <script src="../lib/jquery/jquery-1_9_1.min.js"></script>-->

        <script>window.jQuery || document.write('<script src="../lib/jquery/jquery-slim.min.js"><\/script>')</script>
        <script src="../js/popper.min.js"></script>
        <script src="../lib/bootstrap/js/bootstrap.min.js"></script>

        <!-- Icons com cdn -->
        <!--<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>-->

        <!-- Icons sem cdn -->
        <script src="../lib/feather-icon/feather.min.js"></script>

        <script>
            feather.replace()
        </script>

        <!-- Graphs link cdn -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>-->

        <!-- Graphs link sem cdn-->
        <script src="../lib/ajax/ajax-chart-2_7_1.min.js"></script>
        <script src="../lib/angularjs/angular.min.js"></script>
        <script src="../lib/angularjs/angular-route.min.js"></script>
        <script src="../js/app/app.js"></script>
        <script src="../js/app/controllers.js"></script>
        <script src="../lib/jquery/buscaDinamica.js"></script>
        <script src="../lib/ajax/requisicoesAjax.js"></script>
    </body>
</html>
