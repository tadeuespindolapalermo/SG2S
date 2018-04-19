<?php
	session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    // GRADE
    $grade = new Grade();
    $gradeDao = new GradeDao();

	if($_SESSION['perfil_idperfil'] == 2) {
		unset($_SESSION['usuario']);
	    unset($_SESSION['email']);
	    session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectGrade = $gradeDao->listarCombo($conn);


 ?>

<div class="container">

	<br /><br />

    <div class="col-md-4"></div>
	<div class="col-md-12">
		<br />
		<h3><strong><div style="margin-top: -50px;">Gerar Grade Semestral</div></strong></h3>
		<br />

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="listaUsuarios" border="1">
                                <thead>
                                    <tr>
                                        <th>SEMESTRE<br>TURMA</th>
                                        <th>Nª DE ALUNOS</th>
                                        <th>SEGUNDA</th>
                                        <th>TERÇA</th>
                                        <th>QUARTA</th>
                                        <th>QUINTA</th>
                                        <th>SEXTA</th>
                                        <th>SÁBADO</th>
                                        <th>EAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <div style="text-align: center;"><p>FACULDADE JK</p></div>
                                        <div style="text-align: center;"><p>GRADE HORÁRIA: TECNÓLOGO EM ANÁLISE E DESENVOLVIMENTO DE SISTEMAS - 1º SEMESTRE DE 2018</p></div>
                                        <div style="text-align: center;"><p>Período: 19:10 às 20:00 / 20:00 às 20:50 / 21:10 às 22:00</p></div>
                                        <td>TADS 1A</td>										
                                        <td>Disciplinas</td>
                                        <td>Lógica de Programação e Algoritmos</td>
                                        <td>Geometria Anallítica e Agebra Linear</td>
                                        <td>Organização e Arquitatura de Computadores</td>
                                        <td>Metodologia Científica I</td>
                                        <td>Língua Portuguesa - Gramática Básica, Leitura e Interpretação de Textos</td>
                                        <td></td>
                                        <td>Inglês Instrumental(EAD)</td>
                                    </tr>
									<tr>
										<td>TADS 1A</td>
                                        <td>Disciplinas</td>
                                        <td>Lógica de<br> Programação e<br/> Algoritmos</td>
                                        <td>Geometria Anallítica e Agebra Linear</td>
                                        <td>Organização e Arquitatura de Computadores</td>
                                        <td>Metodologia Científica I</td>
                                        <td>Língua Portuguesa - Gramática Básica, Leitura e Interpretação de Textos</td>
                                        <td></td>
                                        <td>Inglês Instrumental(EAD)</td>
									</tr>
									<tr>
										<td>TADS 1A</td>
                                        <td>Disciplinas</td>
                                        <td>Lógica de<br> Programação e<br/> Algoritmos</td>
                                        <td>Geometria Anallítica e Agebra Linear</td>
                                        <td>Organização e Arquitatura de Computadores</td>
                                        <td>Metodologia Científica I</td>
                                        <td>Língua Portuguesa - Gramática Básica, Leitura e Interpretação de Textos</td>
                                        <td></td>
                                        <td>Inglês Instrumental(EAD)</td>
									</tr>
									<tr>
										<td>TADS 1A</td>
                                        <td>Disciplinas</td>
                                        <td>Lógica de<br> Programação e<br/> Algoritmos</td>
                                        <td>Geometria Anallítica e Agebra Linear</td>
                                        <td>Organização e Arquitatura de Computadores</td>
                                        <td>Metodologia Científica I</td>
                                        <td>Língua Portuguesa - Gramática Básica, Leitura e Interpretação de Textos</td>
                                        <td></td>
                                        <td>Inglês Instrumental(EAD)</td>
									</tr>
									<tr>
										<td>TADS 1A</td>
                                        <td>Disciplinas</td>
                                        <td>Lógica de<br> Programação e<br/> Algoritmos</td>
                                        <td>Geometria Anallítica e Agebra Linear</td>
                                        <td>Organização e Arquitatura de Computadores</td>
                                        <td>Metodologia Científica I</td>
                                        <td>Língua Portuguesa - Gramática Básica, Leitura e Interpretação de Textos</td>
                                        <td></td>
                                        <td>Inglês Instrumental(EAD)</td>
									</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
