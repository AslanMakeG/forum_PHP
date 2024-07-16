<?php
    session_start();
    require_once 'connect.php';

    $theme_id = $_POST['id'];

    $user_query = mysqli_query($connect, 
    "SELECT `user_id` FROM `themes`
    WHERE `id` = '$theme_id'");

    $user = mysqli_fetch_assoc($user_query);
    $user = $user['user_id'];

    $forum_query = mysqli_query($connect, 
    "SELECT `forums`.`id` forum_id, `sections`.`id` section_id
    FROM `sections` LEFT JOIN `forums`
    ON `forums`.`id` = `sections`.`forum_id`
    LEFT JOIN `themes` ON `themes`.`section_id` = `sections`.`id`
    WHERE `themes`.`id` = '$theme_id'");

    $forum_result = mysqli_fetch_assoc($forum_query);
    $forum = $forum_result['forum_id'];
    $section = $forum_result['section_id'];

    mysqli_query($connect, 
        "SET FOREIGN_KEY_CHECKS=0;");
    mysqli_query($connect, 
        "DELETE FROM `themes`WHERE `id` = '$theme_id';");

    mysqli_query($connect, 
        "DELETE FROM `theme_images`
        WHERE `theme_id` = '$theme_id'");

    $answers_by_theme_query = mysqli_query($connect, 
        "SELECT * FROM `answers` WHERE `theme_id` = '$theme_id';");

    while($row = mysqli_fetch_assoc($answers_by_theme_query)){
        $user_answer = $row['user_id'];
        $answer_id = $row['id'];

        mysqli_query($connect, 
        "DELETE FROM `answer_images`
        WHERE `answer_id` = '$answer_id'");

        mysqli_query($connect, "DELETE FROM `answers` WHERE `id` = '$answer_id'");

        mysqli_query($connect, 
        "DELETE FROM `answer_images`
        WHERE `answer_id` = '$answer_id'");

        $user_answers_count_query = mysqli_query($connect, 
        "SELECT count(`id`) amount_themes
        FROM `themes`
        WHERE `themes`.`user_id` = '$user_answer'");

        $user_answers_theme_count = mysqli_fetch_assoc($user_answers_count_query);

        $user_answers_count_query = mysqli_query($connect, 
        "SELECT count(`id`) amount_answers
        FROM `answers`
        WHERE `answers`.`user_id` = '$user_answer'");

        $user_answers_answers_count = mysqli_fetch_assoc($user_answers_count_query);

        $user_answers_count = $user_answers_answers_count['amount_answers'] + $user_answers_theme_count['amount_themes'];

        mysqli_query($connect, 
        "UPDATE `users`
        SET `amount_answers` = '$user_answers_count'
        WHERE `id` = '$user_answer'");
    }

    mysqli_query($connect, 
        "SET FOREIGN_KEY_CHECKS=1;");

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

    header('Location: ../section.php?id='. $section);
?>