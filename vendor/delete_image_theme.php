<?php
    session_start();
    require_once 'connect.php';

    $image_id = $_POST['id'];
    $page = $_POST['page'];

    $theme_query = mysqli_query($connect, 
    "SELECT `themes`.`id` theme_id FROM `themes` JOIN `theme_images` ON `themes`.`id` = `theme_images`.`theme_id` 
    WHERE `theme_images`.`id` = '$image_id'");
    $theme = mysqli_fetch_assoc($theme_query);
    $theme = $theme['theme_id'];

    mysqli_query($connect,
    "DELETE FROM `theme_images` WHERE `id` = '$image_id'");

    header('Location: ../theme.php?theme_id=' . $theme . '&page=' . $page);
?>