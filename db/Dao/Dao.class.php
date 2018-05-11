<?php
ob_start();
interface Dao {

    public function inserir($conn, $object);
    public function remover($conn, $id);
    public function atualizar($conn, $object);
    public function listar($conn);

}
