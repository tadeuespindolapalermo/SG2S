<?php
    if($_SESSION['perfil_idperfil'] == 1) {
        echo "
        <script type=\"text/javascript\">
            alert(\"ALERTA!!! VOCÊ ACESSOU O PERFIL DE COORDENADOR ATRAVÉS DO PERFIL DE ADMINISTRADOR!!! ACESSO AO CRUD DE USUÁRIOS NÃO PERMITIDO!!!\");
        </script>";
        /*unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../controller/controller_sair.php');*/
    }
    echo "
    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
    http://localhost/SG2S/view/view_coordenador.php?pagina=view_professores_lixeira_listagem.php'";
    sleep(2);
?>
