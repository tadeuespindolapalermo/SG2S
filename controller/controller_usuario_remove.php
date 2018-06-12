<?php
    session_start();
    ob_start();
    require('../db/Config.inc.php');

    // CONEXÃO COM PDO
    $PDO = new Conn;
    $conn = $PDO->Conectar();

    $usuarioDao = new UsuarioDao();

    $idUsuario = $_GET['idUsuario'];

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

    // Removendo usuário do banco
    $linhas = $usuarioDao->remover($conn, $idUsuario);

    if ($linhas != 0) {
        echo '
        <center>
            <div class="alert alert-success" style="width: 455px;">
                Usuário excluído com sucesso!
            </div>
        </center>';
        echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_ponte_admin_usuario.php'";
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao excluir usuário!\");
        </script>
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
        http://localhost/SG2S/view/view_admin.php?pagina=view_usuarios_listagem.php'";
    }
