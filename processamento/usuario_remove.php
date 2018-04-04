<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/sair.php');
    }

    require('../db/Config.inc.php');

    $idUsuario = $_GET['idUsuario'];

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    try {
        $sqlIdUsuario = "DELETE FROM usuarios WHERE idusuarios = :idUsuario";
        $selectIdUsuario = $conn->prepare($sqlIdUsuario);
        $selectIdUsuario->bindValue(':idUsuario', $idUsuario);
        $selectIdUsuario->execute();

        $linhas = $selectIdUsuario->rowCount();

        if ($linhas != 0) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Usuário excluído com sucesso!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao excluir usuário!\");
            </script>
            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
            http://localhost/SG2S/view/admin.php?pagina=usuarios_listagem.php'";
        }
    } catch (PDOException $e) {
        PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
    }
