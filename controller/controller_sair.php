<?php
    session_start();
    ob_start();

    unset($_SESSION['usuario']);
    unset($_SESSION['email']);
    session_destroy();

    header('Location: ../#!/index');
