<?php
    session_start();

    if($_SESSION['perfil_idperfil'] == 2) {
        unset($_SESSION['usuario']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: ../processamento/process_sair.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        require('../db/Config.inc.php');

        // CONEXÃO COM PDO
        $PDO = new Conn;
        $conn = $PDO->Conectar();

        $curso = new Curso();

        // Dados recebidos do formulário via POST
        $curso->setNome($_POST['nome']);
        $curso->setPortaria($_POST['portaria']);
        $curso->setDuracao($_POST['duracao']);
        $curso->setGrau($_POST['grau']);
        $curso->setDataPortaria($_POST['dataPortaria']);
        $curso->setIdCurso($_GET['idCurso']);

        try {
            // UPDATE DO USUÁRIO
            $strSqlCurso = "
            UPDATE curso set
                nome = :nome,
                portaria = :portaria,
                duracao = :duracao,
                grau = :grau,
                data_portaria = :dataPortaria
            WHERE
                idcurso = :idCurso";

            $stmtUpdateCurso = $conn->prepare($strSqlCurso);
            $stmtUpdateCurso->bindValue(':nome', $curso->getNome());
            $stmtUpdateCurso->bindValue(':portaria', $curso->getPortaria());
            $stmtUpdateCurso->bindValue(':duracao', $curso->getDuracao());
            $stmtUpdateCurso->bindValue(':grau', $curso->getGrau());
            $stmtUpdateCurso->bindValue(':dataPortaria', $curso->getDataPortaria());
            $stmtUpdateCurso->bindValue(':idCurso', $curso->getIdCurso());
            $updateCurso = $stmtUpdateCurso->execute();
            // -----------------------------------------------------------

            // VALIDAÇÃO DO UPDATE
            if ($updateCurso) {

                echo "
                <script type=\"text/javascript\">
                    alert(\"Curso atualizado com sucesso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
                //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
            } else {
                echo "
                <script type=\"text/javascript\">
                    alert(\"Erro ao atualizar o curso!\");
                </script>
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=
                http://localhost/SG2S/view/view_admin.php?pagina=view_cursos_listagem.php'";
                //header('Location: ../view/view_admin.php?pagina=view_cursos_listagem.php');
            }
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }
?>
