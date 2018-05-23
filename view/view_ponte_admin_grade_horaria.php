<?php
    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');
    }
    echo "
    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
    http://localhost/SG2S/view/view_admin.php?pagina=view_grades_horarias_listagem.php'";
    sleep(2);
?>
