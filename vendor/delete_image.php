<?php
    session_start();
    require_once 'connect.php';

    $image_id = $_POST['id'];
    $page = $_POST['page'];

    $theme_query = mysqli_query($connect, 
    "SELECT `answers`.`theme_id` theme_id FROM `answers` JOIN `answer_images` ON `answers`.`id` = `answer_images`.`answer_id` 
    WHERE `answer_images`.`id` = '$image_id'");
    $theme = mysqli_fetch_assoc($theme_query);
    $theme = $theme['theme_id'];

    mysqli_query($connect,
    "DELETE FROM `answer_images` WHERE `id` = '$image_id'");

    header('Location: ../theme.php?theme_id=' . $theme . '&page=' . $page);
?>