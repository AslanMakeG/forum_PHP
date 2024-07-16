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
    <link href="css/register.css" rel="stylesheet">
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
        <div class="register">
            <div class="register-head">
                <p style="color: white; font-family: Roboto-Light;">Регистрация</p>
            </div>
            <div class="register-body">
                <?php
                    if(isset($_SESSION['register_error'])){
                        echo '<p class="register-error">' . $_SESSION['register_error'] . '</p>';
                        unset($_SESSION['register_error']);
                    }
                ?>
                <form class="form-register" action="/vendor/registration.php" method="POST">
                    <p class="register-input-p">ФИО</p>
                    <input class="register-input" type="text" name="name" required
                    <?php
                        if (isset($_SESSION['register-data'])){
                            echo 'value="' . $_SESSION['register-data']['name'] . '"';
                        }                        
                    ?>>
                    <p class="register-input-p">Email</p>
                    <input class="register-input" type="email" name="email" required                    
                    <?php
                        if (isset($_SESSION['register-data'])){
                            echo 'value="' . $_SESSION['register-data']['email'] . '"';
                        }                        
                    ?>>
                    <p class="register-input-p">Логин</p>
                    <input class="register-input" type="text" name="login" required
                    <?php
                        if (isset($_SESSION['register-data'])){
                            echo 'value="' . $_SESSION['register-data']['login'] . '"';
                        }                        
                    ?>>
                    <p class="register-input-p">Пароль</p>
                    <input id="password" class="register-input" type="password" name="password" required
                    <?php
                        if (isset($_SESSION['register-data'])){
                            echo 'value="' . $_SESSION['register-data']['password'] . '"';
                        }                        
                    ?>>
                    <p class="register-input-p">Повторите пароль</p>
                    <input id="repeatpassword" class="register-input" type="password" name="repeat_password" required                    
                    <?php
                        if (isset($_SESSION['register-data'])){
                            echo 'value="' . $_SESSION['register-data']['repeat_password'] . '"';
                        }                        
                    ?>><br>
                    
                    <div class="check-password">
                        <input id="checkpassword" class="login-input-check" type="checkbox">
                        <p class="check-password-p">Показать пароли</p>
                    </div>

                    <input class="register-button" type="submit" value="Зарегестрироваться">
                    <div class="need-to-login">
                        <p style="margin-bottom: 7px; font-family: Roboto-Light;">Уже есть аккаунт?</p>
                        <a class="login-link" href="login.php">Войти!</a>
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