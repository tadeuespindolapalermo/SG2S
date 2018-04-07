<?php

// CONFIGRAÇÕES DO SISTEMA ####################
define('HOME', 'http://localhost/SG2S/#!/');

// CONFIGRAÇÕES DO BANCO ####################
define('HOST', 'xmysql2.codigofonteonline.com.br');
define('USER', 'codigofonteonli1');
define('PASS', 'sg2s1985@');
define('DBSA', 'codigofonteonline1');

// AUTO LOAD DE CLASSES ####################
function __autoload($Class) {

    $cDir = ['Conn','Model'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . "/{$dirName}/{$Class}.class.php") && !is_dir(__DIR__ . "/{$dirName}/{$Class}.class.php")):
            include_once (__DIR__ . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('SG2S_ACCEPT', 'accept');
define('SG2S_INFOR', 'infor');
define('SG2S_ALERT', 'alert');
define('SG2S_ERROR', 'error');

//SG2SErro :: Exibe erros lançados :: Front
function SG2SErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? SG2S_INFOR : ($ErrNo == E_USER_WARNING ? SG2S_ALERT : ($ErrNo == E_USER_ERROR ? SG2S_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";

    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? SG2S_INFOR : ($ErrNo == E_USER_WARNING ? SG2S_ALERT : ($ErrNo == E_USER_ERROR ? SG2S_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');
