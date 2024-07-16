<?php
    session_start();
    require_once 'connect.php';

    $theme_id = $_GET['theme_id'];
    $status = $_GET['status'];

    $forum_query = mysqli_query($connect, 
    "SELECT `forums`.`id` forum_id, `sections`.`id` section_id
    FROM `sections` LEFT JOIN `forums`
    ON `forums`.`id` = `sections`.`forum_id`
    LEFT JOIN `themes` ON `themes`.`section_id` = `sections`.`id`
    WHERE `themes`.`id` = '$theme_id'");

    $forum_result = mysqli_fetch_assoc($forum_query);
    $section = $forum_result['section_id'];

    mysqli_query($connect, 
        "UPDATE `themes`
        SET `status` = '$status'
        WHERE `id` = '$theme_id';");

    header('Location: ../theme.php?&theme_id=' . $theme_id);
?>