<?php
    session_start();
    require_once 'connect.php';

    $body = $_POST['body'];
    $answer = $_POST['answer'];
    $page = $_POST['page'];

    $theme_query = mysqli_query($connect, 
    "SELECT * FROM `answers` WHERE `id` = '$answer'");
    $theme = mysqli_fetch_assoc($theme_query);
    $theme = $theme['theme_id'];

    mysqli_query($connect, 
    "UPDATE `answers`
    SET `body` = '$body'
    WHERE `id` = '$answer'");

    header('Location: ../theme.php?theme_id=' . $theme . '&page=' . $page);
?>