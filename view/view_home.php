<?php
    ob_start();
    echo "<h6><strong>{$_SESSION['nome']}</strong><br /><strong><font color='#FF0000'>{$_SESSION['email']}</font></strong></h6>";

    echo '<hr><li>Links úteis:';
    /*<ul><a href="https://www.unicollege.net/jkfatep/Login.aspx" target="_blank"><br />Área do Aluno - JK Santa Maria</a></ul>
    <ul><a href="https://www.unicollege.net/jkmichelangelo/Login.aspx" target="_blank">Área do Aluno - JK Taguatinga</a></ul>
    <ul><a href="https://www.unicollege.net/jkserrana/Login.aspx" target="_blank">Área do Aluno - JK Asa Norte</a></ul>*/
    echo '
    <ul><a href="https://www.faculdade.jk.edu.br/" target="_blank"><br />Faculdade JK - Site Oficial</a></ul>
    <ul><a href="http://www.codigofonteonline.com.br/" target="_blank">Código Fonte Online</a></ul>
    <ul><a href="https://moodle.jk.edu.br/" target="_blank">AVA Moodle - JK</a></ul></li>
    <ul><a href="http://santamaria24h.com/" target="_blank">Santa Maria 24h</a></ul>
    ';
