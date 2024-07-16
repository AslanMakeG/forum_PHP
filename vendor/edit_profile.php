<?php
    require_once 'connect.php';
    session_start();

    $user_id = $_SESSION['user']['id'];
    $name = $_POST['name'];
    $about = $_POST['about'];
    $file = $_FILES['avatar']['tmp_name'];

    $image = addslashes(file_get_contents($file));

    mysqli_query($connect,
    "UPDATE `users`
    SET `name` = '$name', `about` = '$about', `avatar` = '$image'
    WHERE `id` = '$user_id'");
    
    header('Location: ../profile.php');
?>