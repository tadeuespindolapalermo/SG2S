<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $usuarios = new Usuarios();
        $perfil = new Perfil();

        $idUsuarioSessao = $_SESSION['idusuarios'];

        // Dados recebidos do formulário via POST
        $usuarios->setNome($_POST['nome']);
        $usuarios->setFone($_POST['telefone']);
        $usuarios->setEmail($_POST['email']);
        $usuarios->setUsuario($_POST['usuario']);
        $senhaNormal = $_POST['senha'];
        $usuarios->setSenha(md5($_POST['senha']));

        try {
            $strSqlUsuarioLogado = "
            UPDATE usuarios set
                nome = :nome,
                fone = :telefone,
                usuario = :usuario,
                email = :email,
                senha = :senha
            WHERE
                idusuarios= :idUsuarioSessao";

            $stmtUpdateUsuarioLogado = $conn->prepare($strSqlUsuarioLogado);
            $stmtUpdateUsuarioLogado->bindValue(':nome', $usuarios->getNome());
            $stmtUpdateUsuarioLogado->bindValue(':telefone', $usuarios->getFone());
            $stmtUpdateUsuarioLogado->bindValue(':email', $usuarios->getEmail());
            $stmtUpdateUsuarioLogado->bindValue(':usuario', $usuarios->getUsuario());
            $stmtUpdateUsuarioLogado->bindValue(':senha', $usuarios->getSenha());
            $stmtUpdateUsuarioLogado->bindValue(':idUsuarioSessao', $idUsuarioSessao);
            $updateUsuarioLogado = $stmtUpdateUsuarioLogado->execute();

            if ($updateUsuarioLogado) {

                $_SESSION['senha'] = $senhaNormal;
                $_SESSION['nome'] = $usuarios->getNome();
                $_SESSION['email'] = $usuarios->getEmail();

                if($_SESSION['perfil_idperfil'] == 2) {
                    echo "
                    <script type=\"text/javascript\">
                        alert(\"Usuário atualizado com sucesso!\");
                    </script>
                    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                    http://localhost/SG2S/view/view_coordenador.php?pagina=view_home.php'";
                    header('Location: ../view/view_coordenador.php?pagina=view_home.php');
                } elseif($_SESSION['perfil_idperfil'] == 1) {
                    echo "
                    <script type=\"text/javascript\">
                        alert(\"Usuário atualizado com sucesso!\");
                    </script>
                    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                    http://localhost/SG2S/view/view_admin.php?pagina=view_home.php'";
                    header('Location: ../view/view_admin.php?pagina=view_home.php');
                }
            } else {
                $retorno_get = '';
                if($_SESSION['perfil_idperfil'] == 1) {

                    $retorno_get.= "erro_update=1&";

                    header('Location: ../view/view_admin.php?pagina=view_form_usuario_logado_update.php&' . $retorno_get);
                    die();

                } elseif ($_SESSION['perfil_idperfil'] == 2) {

                    $retorno_get.= "erro_update=1&";

                    header('Location: ../view/view_coordenador.php?pagina=view_form_usuario_logado_update.php&' . $retorno_get);
                    die();
                }
            }
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }
