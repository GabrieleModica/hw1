<?php
    include 'dbconfig.php';


    session_start();
    session_destroy();

    header('Location: home.php');
?>