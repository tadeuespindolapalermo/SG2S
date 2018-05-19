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

        $cursoDao = new CursoDao();
        $curso = new Curso();

        // Dados recebidos do formulário via POST
        $curso->setNome($_POST['nome']);
        $curso->setPortaria($_POST['portaria']);
        $curso->setDuracao($_POST['duracao']);
        $curso->setGrau($_POST['grau']);
        $curso->setDataPortaria($_POST['dataPortaria']);
        $curso->setIdCurso($_GET['idCurso']);

        // Update do Curso no Banco
        $updateCurso = $cursoDao->atualizar($conn, $curso);

        // VALIDAÇÃO DO UPDATE
        if ($updateCurso && $_SESSION['perfil_idperfil'] == 1) {
            /*echo "
            <script type=\"text/javascript\">
                alert(\"Curso atualizado com sucesso!\");
            </script>*/
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Curso atualizado com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_curso.php'";
            //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
        } elseif ($updateCurso && $_SESSION['perfil_idperfil'] == 2) {
            /*echo "
            <script type=\"text/javascript\">
                alert(\"Curso atualizado com sucesso!\");
            </script>*/
            echo '
            <center>
                <div class="alert alert-success" style="width: 455px;">
                    Curso atualizado com sucesso!
                </div>
            </center>';
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_ponte_coordenador_curso.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_cursos_listagem.php');
        } elseif (!$updateCurso && $_SESSION['perfil_idperfil'] == 1) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o curso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
            //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
        } elseif (!$updateCurso && $_SESSION['perfil_idperfil'] == 2) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar o curso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_coordenador.php?pagina=view_cursos_listagem.php'";
            //header('Location: ../view/view_coordenador.php?pagina=view_cursos_listagem.php');
        }
    }
?>
