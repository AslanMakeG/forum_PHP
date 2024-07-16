<?php
    session_start();
    require_once 'connect.php';

    $name = $_POST['name'];
    $body = $_POST['body'];
    $section = $_POST['section'];
    $user = $_SESSION['user']['id'];

    $files = $_FILES['userfile']['tmp_name'];

    $date = date('Y-m-d');
    $time = date('H:i:s');

    mysqli_query($connect, 
        "INSERT INTO `themes` (`id`, `name`, `body`, `date`, `time`, `status`, `amount_answers`, `date_last_answer`, `time_last_answer`, `user_id`,`section_id`) 
        VALUES (NULL, '$name', '$body', '$date', '$time', 'open', 1, '$date', '$time', '$user','$section')");


    $forum_query = mysqli_query($connect, 
    "SELECT `forums`.`id` forum_id
    FROM `sections` LEFT JOIN `forums`
    ON `forums`.`id` = `sections`.`forum_id`
    WHERE `sections`.`id` = '$section'");

    $forum = mysqli_fetch_assoc($forum_query);
    $forum = $forum['forum_id'];

    $themes_count_query = mysqli_query($connect, 
    "SELECT count(`themes`.`id`) as `count_themes`, sum(`themes`.`amount_answers`) as `count_answers` FROM `themes` 
    JOIN `sections` ON `themes`.`section_id` = `sections`.`id` 
    JOIN `forums` ON `sections`.`forum_id` = `forums`.`id` WHERE `forums`.`id` = '$forum';");

    $themes_count = mysqli_fetch_assoc($themes_count_query);
    $answers_count = $themes_count['count_answers'];
    $themes_count = $themes_count['count_themes'];

    mysqli_query($connect, 
    "UPDATE `forums`
    SET `amount_themes` = '$themes_count', `amount_answers` = '$answers_count'
    WHERE `id` = '$forum'");

    $theme_query = mysqli_query($connect, "SELECT LAST_INSERT_ID()");
    
    $theme_id = mysqli_fetch_assoc($theme_query);
    $theme_id = $theme_id['LAST_INSERT_ID()'];

    for($i = 0; $i < count($files); $i++){
        if(filesize($files[$i]) > 0){
            $image = addslashes(file_get_contents($files[$i]));
            mysqli_query($connect, 
                "INSERT INTO `theme_images` (`id`, `image`, `theme_id`) 
                VALUES (NULL, '$image', '$theme_id')");
        }
    }

    echo mysqli_error($connect);

    $user_answers_count_query = mysqli_query($connect, 
    "SELECT count(`id`) amount_themes
    FROM `themes`
    WHERE `themes`.`user_id` = '$user'");

    $user_answers_theme_count = mysqli_fetch_assoc($user_answers_count_query);

    $user_answers_count_query = mysqli_query($connect, 
    "SELECT count(`id`) amount_answers
    FROM `answers`
    WHERE `answers`.`user_id` = '$user'");

    $user_answers_answers_count = mysqli_fetch_assoc($user_answers_count_query);

    $user_answers_count = $user_answers_answers_count['amount_answers'] + $user_answers_theme_count['amount_themes'];

    mysqli_query($connect, 
    "UPDATE `users`
    SET `amount_answers` = '$user_answers_count'
    WHERE `id` = '$user'");

    header('Location: ../theme.php?theme_id=' . $theme_id);

?>