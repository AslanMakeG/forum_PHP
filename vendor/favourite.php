<?php
    require_once 'connect.php';
    session_start();

    $user_id = $_SESSION['user']['id'];
    $theme_id = $_GET['theme_id'];
    $page = $_GET['page'];

    $favourite_theme_query = mysqli_query($connect, 
    "SELECT * 
    FROM `favourite_themes`
    WHERE `user_id` = '$user_id' AND `theme_id` = '$theme_id'");

    $section_query = mysqli_query($connect, 
    "SELECT * 
    FROM `themes`
    WHERE `id` = '$theme_id'");

    $section = mysqli_fetch_assoc($section_query);
    $section_id = $section['section_id'];
    
    if(mysqli_num_rows($favourite_theme_query) > 0){
        mysqli_query($connect, 
        "DELETE FROM `favourite_themes`
        WHERE `user_id` = '$user_id' AND `theme_id` = '$theme_id'");
    }
    else{
        mysqli_query($connect, 
        "INSERT INTO `favourite_themes` (`id`, `user_id`, `theme_id`)
        VALUES (NULL, '$user_id', '$theme_id')");
    }    
    
    header('Location: ../theme.php?&theme_id=' . $theme_id . '&page=' . $page);
?>