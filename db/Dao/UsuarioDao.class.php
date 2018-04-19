<?php

class UsuarioDao implements Dao {

    /*
     * Método para inserir um novo usuário no sistema (controller)
     **/
    public function inserir($conn, $usuario) {

        $usuario_existe = false;
        $email_existe = false;

        // VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
        $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $selectUsuario = $conn->prepare($sqlUsuario);
        $selectUsuario->bindValue(':usuario', $usuario->getUsuario());
        $selectUsuario->execute();

        if ($selectUsuario->rowCount() >= 1) {
            $dados_usuario = $selectUsuario->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados_usuario as $dados)
                $usuario_existe = isset($dados["usuario"]);

        } else {
            echo 'Erro ao tentar localizar o registro de usuário!';
        }
        // -------------------------------------------------------------

        // VERIFICA SE O E-MAIL INFORMADO EXISTE NO SISTEMA
        $sqlEmail = "SELECT * FROM usuarios WHERE email = :email";
        $selectEmail = $conn->prepare($sqlEmail);
        $selectEmail->bindValue(':email', $usuario->getEmail());
        $selectEmail->execute();

        if ($selectEmail->rowCount() >= 1) {
            $dados_usuario = $selectEmail->fetchAll(PDO::FETCH_ASSOC);

            foreach($dados_usuario as $dados)
                $email_existe = isset($dados["email"]);

        } else {
            echo 'Erro ao tentar localizar o registro de usuário!';
        }
        // -----------------------------------------------------

        if ($usuario_existe || $email_existe) {

            $retorno_get = '';

            if ($usuario_existe) {
                $retorno_get.= "erro_usuario=1&";
            }

            if ($email_existe) {
                $retorno_get.= "erro_email=1&";
            }
            header('Location: ../view/view_admin.php?pagina=view_form_usuario_cadastro.php&' . $retorno_get);
            die();
        }
        // --------------------------------------------------

        // INSERÇÃO DE USUÁRIO COM PDO
        try {
            $sqlUsuario = "INSERT INTO usuarios(nome, fone, email, usuario, senha) VALUES (?, ?, ?, ?, ?)";

            $stmtCreateUsuario = $conn->prepare($sqlUsuario);

            $stmtCreateUsuario->bindValue(1, $usuario->getNome(), PDO::PARAM_STR);
            $stmtCreateUsuario->bindValue(2, $usuario->getFone(), PDO::PARAM_STR);
            $stmtCreateUsuario->bindValue(3, $usuario->getEmail(), PDO::PARAM_STR);
            $stmtCreateUsuario->bindValue(4, $usuario->getUsuario(), PDO::PARAM_STR);
            $stmtCreateUsuario->bindValue(5, $usuario->getSenha(), PDO::PARAM_STR);

            $cadastroUsuarioEfetuado = $stmtCreateUsuario->execute();

            return $cadastroUsuarioEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para inserir o perfil do novo usuário no sistema (chave estrangeira) (controller)
     **/
    public function inserirPerfil($conn, $usuario, $perfil) {
        try {
            // BUSCAR ID DO USUÁRIO INSERIDO
            $sqlIdUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
            $selectIdUsuario = $conn->prepare($sqlIdUsuario);
            $selectIdUsuario->bindValue(':usuario', $usuario->getUsuario());
            $selectIdUsuario->execute();

            if ($selectIdUsuario->rowCount() >= 1) {
                $dados_id_usuario = $selectIdUsuario->fetchAll(PDO::FETCH_ASSOC);

                foreach($dados_id_usuario as $dados_id)
                    $usuario->setIdUsuarios($dados_id['idusuarios']);
            }
            // --------------------------------------------------

            // INSERÇÃO DE PERFIL DO USUÁRIO COM PDO
            $sqlPerfilUsuario = "INSERT INTO usuario_perfil(usuarios_idusuarios, perfil_idperfil) VALUES (?, ?)";

            $stmtCreatePerfil = $conn->prepare($sqlPerfilUsuario);

            $stmtCreatePerfil->bindValue(1, $usuario->getIdUsuarios(), PDO::PARAM_INT);
            $stmtCreatePerfil->bindValue(2, $perfil->getIdPerfil(), PDO::PARAM_INT);

            $cadastroPerfilUsuarioEfetuado = $stmtCreatePerfil->execute();

            return $cadastroPerfilUsuarioEfetuado;
            // -----------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para remover um usuário no sistema (controller)
     **/
    public function remover($conn, $idUsuario) {
        try {
            $sqlIdUsuario = "DELETE FROM usuarios WHERE idusuarios = :idUsuario";
            $selectIdUsuario = $conn->prepare($sqlIdUsuario);
            $selectIdUsuario->bindValue(':idUsuario', $idUsuario);
            $selectIdUsuario->execute();

            $linhas = $selectIdUsuario->rowCount();

            return $linhas;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar um usuário no sistema (controller)
     **/
    public function atualizar($conn, $usuario) {

        try {
            // UPDATE DO USUÁRIO
            $strSqlUsuario = "
            UPDATE usuarios set
                nome = :nome,
                fone = :telefone,
                usuario = :usuario,
                email = :email,
                senha = :senha
            WHERE
                idusuarios = :idUsuario";

            $stmtUpdateUsuario = $conn->prepare($strSqlUsuario);
            $stmtUpdateUsuario->bindValue(':nome', $usuario->getNome());
            $stmtUpdateUsuario->bindValue(':telefone', $usuario->getFone());
            $stmtUpdateUsuario->bindValue(':email', $usuario->getEmail());
            $stmtUpdateUsuario->bindValue(':usuario', $usuario->getUsuario());
            $stmtUpdateUsuario->bindValue(':senha', $usuario->getSenha());
            $stmtUpdateUsuario->bindValue(':idUsuario', $usuario->getIdUsuarios());
            $updateUsuario = $stmtUpdateUsuario->execute();

            return $updateUsuario;
            // -----------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar o perfil do usuário atualizado (controller)
     **/
    public function atualizarPerfil($conn, $usuario, $perfil) {

        try {
            // UPDATE DO PERFIL DO USUÁRIO
            $strSqlPerfilUsuario = "
            UPDATE usuario_perfil set
                perfil_idperfil = :idPerfil
            WHERE
                usuarios_idusuarios = :idUsuario";

            $stmtUpdatePerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
            $stmtUpdatePerfilUsuario->bindValue(':idPerfil', $perfil->getIdPerfil());
            $stmtUpdatePerfilUsuario->bindValue(':idUsuario', $usuario->getIdUsuarios());
            $updatePerfilUsuario = $stmtUpdatePerfilUsuario->execute();

            return $updatePerfilUsuario;
            // ------------------------------------------------------------
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para atualizar um usuário logado no sistema (controller)
     **/
    public function atualizarUsuarioLogado($conn, $usuario, $idUsuarioSessao) {
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
            $stmtUpdateUsuarioLogado->bindValue(':nome', $usuario->getNome());
            $stmtUpdateUsuarioLogado->bindValue(':telefone', $usuario->getFone());
            $stmtUpdateUsuarioLogado->bindValue(':email', $usuario->getEmail());
            $stmtUpdateUsuarioLogado->bindValue(':usuario', $usuario->getUsuario());
            $stmtUpdateUsuarioLogado->bindValue(':senha', $usuario->getSenha());
            $stmtUpdateUsuarioLogado->bindValue(':idUsuarioSessao', $idUsuarioSessao);
            $updateUsuarioLogado = $stmtUpdateUsuarioLogado->execute();

            return $updateUsuarioLogado;

        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getFile());
        }
    }

    /*
     * Método para listar todos os usuários do sistema (view)
     **/
    public function listar($conn) {
        $strSqlJoin = "SELECT * FROM usuarios INNER JOIN usuario_perfil ON usuarios.idusuarios = usuario_perfil.idusuario_perfil";
        $selectUsuarioJoin = $conn->prepare($strSqlJoin);
        $selectUsuarioJoin->execute();
        return $selectUsuarioJoin;
    }

    /*
     * Método para popular o form de update de um usuário selecionado (usuario) (view)
     **/
    public function buscarUsuarioId($conn, $idUsuario) {
        $strSqlUsuario = "SELECT idusuarios, nome, fone, usuario, email, senha FROM usuarios WHERE idusuarios = :idUsuario";
        $selectUsuario = $conn->prepare($strSqlUsuario);
        $selectUsuario->bindValue(':idUsuario', $idUsuario);
        $selectUsuario->execute();
        return $selectUsuario;
    }

    /*
     * Método para popular o form de update de um usuário selecionado (perfil) (view)
     **/
    public function buscarPerfilId($conn, $idUsuario) {
        $strSqlPerfilUsuario = "SELECT perfil_idperfil FROM usuario_perfil WHERE usuarios_idusuarios = :idUsuario";
        $selectPerfilUsuario = $conn->prepare($strSqlPerfilUsuario);
        $selectPerfilUsuario->bindValue(':idUsuario', $idUsuario);
        $selectPerfilUsuario->execute();
        return $selectPerfilUsuario;
    }

    /*
     * Método para popular o form de usuário logado (view)
     **/
    public function buscarUsuarioLogado($conn, $idUsuarioSessao) {
        $strSqlUsuario = "SELECT nome, fone, usuario, email, senha FROM usuarios WHERE idusuarios = :idUsuario";
        $selectUsuario = $conn->prepare($strSqlUsuario);
        $selectUsuario->bindValue(':idUsuario', $idUsuarioSessao);
        $selectUsuario->execute();
        return $selectUsuario;
    }

    /*
     * VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
     * Método utilizado no Login (controller)
     **/
    public function buscarUsuarioLogin($conn, $usuario) {
        $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha";
        $selectUsuario = $conn->prepare($sqlUsuario);
        $selectUsuario->bindValue(':usuario', $usuario->getUsuario());
        $selectUsuario->bindValue(':senha', $usuario->getSenha());
        $selectUsuario->execute();
        return $selectUsuario;
    }

    /*
     * VERIFICA SE O USUÁRIO INFORMADO EXISTE NO SISTEMA
     * Método utilizado no Login (controller)
     **/
    public function buscarPerfilUsuarioLogin($conn, $usuario) {
        $sqlPerfilId = "SELECT perfil_idperfil FROM usuario_perfil WHERE usuarios_idusuarios = :idUsuario";
        $selectPerfilId = $conn->prepare($sqlPerfilId);
        $selectPerfilId->bindValue(':idUsuario', $usuario->getIdUsuarios());
        $selectPerfilId->execute();
        return $selectPerfilId;
    }

}
