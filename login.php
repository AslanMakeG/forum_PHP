<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="css/dropdown.css" rel="stylesheet">
    <link href="css/forum.css" rel="stylesheet">
    <title>Курсовая</title>
</head>
<header>
    <div class="header-div">
        <div class="header-container">
            <div class="header-name">
                <h2 class="title">Forum</h2>
                <img id="danceimage" width="70">
            </div>
            <a id='profile-text' href="login.php">Войти</a>
        </div>
    </div>    
    <div class="under-header-div">
        <div class="under-header-container">
            <div class='dropdown menu'>
                <button class='dropbtn' onclick='showMenu()'>Меню<p class='dropbtn' style="padding-top: 10px; margin: 0 0 0 3px;">🢗</p>
                    <i class='fa fa-caret-down'></i>
                </button>
                <div class='dropdown-content drop-menu' id='myDropdown3'>
                    <a href="index.php">Форум</a>
                    <a href="rules.php">Правила</a>
                    <a href="about.php">О нас</a>     
                </div>
            </div>

            <div class="main-menu">
                <a class="header-link" href="index.php">Форум</a>
                <a class="header-link" href="rules.php">Правила</a>
                <a class="header-link" href="about.php">О нас</a>     
            </div>

            <div class='dropdown'>
                <button class='dropbtn' onclick='showSearch()'>Поиск тем <p class='dropbtn' style="padding-top: 10px; margin: 0 0 0 3px;">🢗</p>
                    <i class='fa fa-caret-down'></i>
                </button>
                <div class='dropdown-content contentsearch' id='myDropdown2'>
                    <form class="searchForm" action="search.php" method="GET">
                        <input class="searchField" type="text" name="search_themes">
                        <input type="hidden" name="page" value="1">
                        <input class="searchButton" type="submit" value="Найти">
                    </form>
                </div>
            </div>

        </div>
    </div>  
</header>
<body>
    <div class="main-content">
        <div class="login">
            <div class="login-head">
                <p style="color: white; font-family: Roboto-Light;">Вход</p>
            </div>
            <div class="login-body">
                <?php
                    if(isset($_SESSION['login_error'])){
                        echo '<p class="login_error">' . $_SESSION['login_error'] . '</p>';
                        unset($_SESSION['login_error']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['register_success'])){
                        echo '<p class="register_success">' . $_SESSION['register_success'] . '</p>';
                        unset($_SESSION['register_success']);
                    }
                ?>
                <form class="form-login" action="/vendor/login.php" method="POST">
                    <p class="login-input-p">Логин</p>
                    <input class="login-input" type="text" name="login" required>
                    <p class="login-input-p">Пароль</p>
                    <input id="password" class="login-input" type="password" name="password" required><br>
                    <div class="check-password">
                        <input id="checkpassword" class="login-input-check" type="checkbox">
                        <p class="check-password-p">Показать пароль</p>
                    </div>
                    <input class="login-button" type="submit" value="Войти">
                    <div class="need-to-register">
                        <p style="margin-bottom: 7px; font-family: Roboto-Light;">Нет аккаунта?</p>
                        <a class="register-link" href="register.php">Зарегестрироваться!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<footer>
    <div class="footer-div">
        <div class="footer-container">
            <a class="footer-link" href="support.php">Поддержать</a>
            <a class="footer-link" href="feedback.php">Обратная связь</a>
        </div>
    </div>
</footer>
<script src="js/dropdown.js"></script>
<script src="js/dance_image.js"></script>
<script src="js/show_password.js"></script>
</html>