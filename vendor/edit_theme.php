<?php
    session_start();
    require_once 'connect.php';

    $body = $_POST['body'];
    $theme = $_POST['theme'];
    $page = 1;

    mysqli_query($connect, 
    "UPDATE `themes`
    SET `body` = '$body'
    WHERE `id` = '$theme'");

    header('Location: ../theme.php?theme_id=' . $theme . '&page=' . $page);
?>