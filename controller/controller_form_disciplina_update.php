<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    /*if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }*/

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $disciplinaDao = new DisciplinaDao();
        $disciplina = new Disciplina();

        // Dados recebidos do formulário via POST
        //$disciplina->setCursoIdCurso($_POST['curso']);
        $disciplina->setNomeDisciplina($_POST['nomeDisciplina']);
        $disciplina->setCargaHoraria($_POST['cargaHoraria']);
        $disciplina->setCredito($_POST['credito']);
        $disciplina->setIdDisciplina($_GET['idDisciplina']);

        $disciplina = $disciplinaDao->atualizar($conn, $disciplina);

        // VALIDAÇÃO DO UPDATE
        if ($disciplina && $_SESSION['perfil_idperfil'] == 1) {
            /*echo "
            <script type=\"text/javascript\">
                alert(\"Disciplina atualizada com sucesso!\");
            </script>*/
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Disciplina atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_disciplina.php'";
            //header('Location: ../view/view_admin.php?pagina=view_disciplinas_listagem.php');
        } elseif ($disciplina && $_SESSION['perfil_idperfil'] == 2) {
            /*echo "
            <script type=\"text/javascript\">
                alert(\"Disciplina atualizada com sucesso!\");
            </script>*/
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Disciplina atualizada com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_disciplina.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_disciplinas_listagem.php');
        } elseif (!$disciplina && $_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a disciplina!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_disciplinas_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_disciplinas_listagem.php');
        } elseif (!$disciplina && $_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar a disciplina!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_disciplinas_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_disciplinas_listagem.php');
        }
    }

?>
