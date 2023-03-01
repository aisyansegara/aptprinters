<?php
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();

    setcookie('idUser', '', time()-3600);
    setcookie('keyUser', '', time()-3600);

    header("Location: index.php");
    exit;
?>
