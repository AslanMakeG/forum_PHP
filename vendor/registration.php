<?php
    session_start();
    require_once 'connect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    $_SESSION['register-data'] = [
        "name" => $name,
        "email" => $email,
        "login" => $login,
        "password" => $password,
        "repeat_password" => $repeat_password
    ];

    $check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");

    $check_email = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");

    if(mysqli_num_rows($check_email) > 0){
        $_SESSION['register_error'] = 'Пользователь с таким Email уже существует';
        header('Location: ../register.php');
        die();
    }

    if(mysqli_num_rows($check_login) > 0){
        $_SESSION['register_error'] = 'Пользователь с таким логином уже существует';
        header('Location: ../register.php');
        die();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Вы ввели неправильный Email";
        header('Location: ../register.php');
        die();
    }

    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    
    if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
        $_SESSION['register_error'] = "Пароль должен быть на латинице, длиной минимум 8 символов и содержать одну цифру, одну строчную и прописную букву и один специальный символ";
        header('Location: ../register.php');
        die();
    }

    if($password === $repeat_password){

        $password = hash('sha224', $password);

        $date = date('Y-m-d');

        mysqli_query($connect, 
        "INSERT INTO `users` (`id`, `login`, `password`, `name`, `about`, `email`, `avatar`, `date_register`, `role`, `amount_answers`) 
        VALUES (NULL, '$login', '$password', '$name', '', '$email', '', '$date', 'user', 0)");

        $_SESSION['register_success'] = 'Регистрация прошла успешно';
        unset($_SESSION['register-data']);
        header('Location: ../login.php');
    }
    else{
        $_SESSION['register_error'] = 'Пароли не совпадают';
        header('Location: ../register.php');
    }
?>