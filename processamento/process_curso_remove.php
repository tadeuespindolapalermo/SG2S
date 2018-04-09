<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    require('../db/Config.inc.php');

    $idCurso = $_GET['idCurso'];

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    try {
        $sqlIdCurso = "DELETE FROM curso WHERE idcurso = :idCurso";
        $selectIdCurso = $conn->prepare($sqlIdCurso);
        $selectIdCurso->bindValue(':idCurso', $idCurso);
        $selectIdCurso->execute();

        $linhas = $selectIdCurso->rowCount();

        if ($linhas != 0) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Curso excluído com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao excluir curso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
        }
    } catch (PDOException $e) {
        PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
    }
