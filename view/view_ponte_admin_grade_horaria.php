<?php
    if($_SESSION['perfil_idperfil'] == 2) {
        
        echo "
        <script type=\"text/javascript\">
            alert(\"ATENÇÃO!!! ACESSO NÃO PERMITIDO! VOCÊ ESTÁ TENTANDO ACESSAR UMA PÁGINA QUE PERTENCE AO PERFIL DE ADMINISTRADOR! FAÇA LOGIN NOVAMENTE!\");
        </script>";

        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=../controller/controller_sair.php'";

        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();

        //header('Location: ../controller/controller_sair.php');
    }
    echo "
    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
    http://localhost/SG2S/view/view_admin.php?pagina=view_form_grade_semestral_selecionar.php'";
    sleep(2);
?>
