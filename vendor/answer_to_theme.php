<?php
    session_start();
    require_once 'connect.php';

    $body = (string)$_POST['body'];
    $section = $_POST['section'];
    $theme = $_POST['theme'];
    $user = $_SESSION['user']['id'];
    $page = $_POST['page'];

    $files = $_FILES['userfile']['tmp_name'];

    $date = date('Y-m-d');
    $time = date('H:i:s');

    mysqli_query($connect, 
        "INSERT INTO `answers` (`id`, `body`, `date`, `time`, `theme_id`, `user_id`) 
        VALUES (NULL, '$body', '$date', '$time', '$theme','$user')");

    $answer_query = mysqli_query($connect, "SELECT LAST_INSERT_ID()");
        
    $answer_id = mysqli_fetch_assoc($answer_query);
    $answer_id = $answer_id['LAST_INSERT_ID()'];

    for($i = 0; $i < count($files); $i++){
        if(filesize($files[$i]) > 0){
            $image = addslashes(file_get_contents($files[$i]));
            mysqli_query($connect, 
                "INSERT INTO `answer_images` (`id`, `image`, `answer_id`) 
                VALUES (NULL, '$image', '$answer_id')");
        }
    }

    $forum_query = mysqli_query($connect, 
    "SELECT `forums`.`id` forum_id
    FROM `sections` LEFT JOIN `forums`
    ON `forums`.`id` = `sections`.`forum_id`
    WHERE `sections`.`id` = '$section'");

    $forum = mysqli_fetch_assoc($forum_query);
    $forum = $forum['forum_id'];

    $theme_answers_count_query = mysqli_query($connect, 
    "SELECT count(`answers`.`id`) + 1 count_answers
    FROM `answers` LEFT JOIN `themes`
    ON `answers`.`theme_id` = `themes`.`id`
    WHERE `themes`.`id` = '$theme'");

    $theme_answers_count = mysqli_fetch_assoc($theme_answers_count_query);
    $theme_answers_count = $theme_answers_count['count_answers'];
    
    $date = date('Y-m-d');
    $time = date('H:i:s');

    mysqli_query($connect, 
    "UPDATE `themes`
    SET `amount_answers` = '$theme_answers_count', `date_last_answer` = '$date', `time_last_answer` = '$time'
    WHERE `id` = '$theme'");

    $themes_count_query = mysqli_query($connect, 
    "SELECT sum(`themes`.`amount_answers`) as `count_answers` FROM `themes` 
    JOIN `sections` ON `themes`.`section_id` = `sections`.`id` 
    JOIN `forums` ON `sections`.`forum_id` = `forums`.`id` WHERE `forums`.`id` = '$forum';");

    $themes_count = mysqli_fetch_assoc($themes_count_query);
    $answers_count = $themes_count['count_answers'];

    mysqli_query($connect, 
    "UPDATE `forums`
    SET `amount_answers` = '$answers_count'
    WHERE `id` = '$forum'");

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
    
    header('Location: ../theme.php?theme_id=' . $theme . '&page=' . $page);
?>