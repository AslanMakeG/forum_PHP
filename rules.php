<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/other.css" rel="stylesheet">
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
            <?php 
                if(isset($_SESSION['user'])){
                    echo "<div class='dropdown'>
                            <button class='dropbtn' onclick='showProfile()'>" . $_SESSION['user']['login'] . "
                                <i class='fa fa-caret-down'></i>
                            </button>
                            <div class='dropdown-content' id='myDropdown'>
                                <a href='profile.php'>Профиль</a>
                                <a style='color: red;' href='vendor/logout.php'>Выйти</a>
                            </div>
                        </div>";
                }
                else{
                    echo '<a id="profile-text" href="login.php">Войти</a>';
                }
            ?>        </div>
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
        <div class="bread-crumbs">
            <a class="crumb" href="index.php">Главная</a>
            <p class="crumb">></p>
            <p class="crumb">Правила</p>
        </div>

        <div class="other">
            <div class="other-head">
                <p style="color: white; font-family: Roboto-Light;">Правила</p>
            </div>
            <div class="other-body">
                <h3 class="rule-name">Общие положения</h3>
                <p class="rule">1. Форум предназначен для обсуждения вопросов IT-тематики и смежных с ней.</p>
                <p class="rule">2. Администрация форума не несет ответственности за использование размещенной пользователями.</p>
                <p class="rule">3. Официальными языками форума являются русский и английский языки.</p>
                <h3 class="rule-name">Правила поведения на форуме</h3>
                <p class="rule">1. Уважайте друг друга.</p>
                <p class="rule">2. Не отсылайте других пользователей в поиск и избегайте ссылок на поисковые системы. Самостоятельно найдите ответ на вопрос и разместите его на форуме.</p>
                <p class="rule">3. Не начинайте и не втягивайтесь в конфликты.</p>
                <h3 class="rule-name">Об администрации форума</h3>
                <p class="rule">1. Администратор может удалить вашу тему, если она нарушает правила.</p>
                <p class="rule">2. Администратор может редактировать/удалить ваш ответ.</p>
                <p class="rule">3. Администратор может закрыть вашу тему, если ответ на нее уже получен.</p>
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