<?php
    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = hash('sha224', $_POST['password']);

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' and `password` = '$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "role" => $user['role']
        ];
        if(isset($_SESSION['check_user_id'])){
            $user_id = $_SESSION['check_user_id'];
            unset($_SESSION['check_user_id']);
            header('Location: ../user.php?id=' . $user_id);
        }
        else{
            header('Location: ../index.php');
        }
    }
    else{
        $_SESSION['login_error'] = 'Пользователя с таким логином или паролем не существует';
        header('Location: ../login.php');
    }
?>