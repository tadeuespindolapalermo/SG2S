<?php
    session_start();

    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $gradeDao = new GradeDao();
    $grade = new Grade();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }

    $selectGradeCombo = $gradeDao->listar($conn);

    echo '
    <div class="container" style="margin-left: -25px;">
        <h5 style="margin-left: 12px;">Selecione o ID da Grade a ser gerada:</h5><br />
        <form action="" method="post">
            <div class="form-group ">
                <div class="col-lg-12">

                <label class="col-lg-12 control-label label-usuario">Id</label>
                <div class="form-group" style="width: 70px; margin-bottom: -5px;">
                    <select class="form-control" id="idGrade" name="idGrade" required="required">';
                        while ($linhaGradeCombo = $selectGradeCombo->fetchAll(PDO::FETCH_ASSOC)) {
                            foreach ($linhaGradeCombo as $dados) {
                                $grade->setIdGradeSemestral($dados['idgrade_semestral']);
                                echo '<option value="'.$grade->getIdGradeSemestral().'">'.$grade->getIdGradeSemestral().'</option>';
                            }
                        }
                    echo '
                    </select>
                </div><br/>';
                ?>

                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="button" onclick="javascript:iniciaRequisitaAjax('GET','view_blank.html','true');" class="btn btn-secondary">Voltar</button>
                <?php
                echo '
                </div>
            </div>
        </form>
    </div>';
