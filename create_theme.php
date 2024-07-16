<?php
    session_start();
    require_once 'vendor/connect.php';
    if(!isset($_SESSION['user'])){
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
    <link href="css/create_theme.css" rel="stylesheet">
    <link href="css/forum.css" rel="stylesheet">
    <link href="css/dropdown.css" rel="stylesheet">
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
            ?>
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
        <div class="bread-crumbs">
            <a class="crumb" href="index.php">Главная</a>
            <p class="crumb">></p>
            <?php 
                $section_id = $_GET['section'];
                
                $forum_section_query = mysqli_query($connect, 
                "SELECT `forums`.`name` forum_name, `sections`.`name` section_name
                FROM `sections` LEFT JOIN `forums`
                ON `forums`.`id` = `sections`.`forum_id`
                WHERE `sections`.`id` = '$section_id'");

                $forum_section_names = mysqli_fetch_assoc($forum_section_query);

                echo '<a class="crumb" href="index.php">' . $forum_section_names['forum_name'] . '</a>'
                . '<p class="crumb">></p>' 
                . '<a class="crumb" href="section.php?id=' . $section_id . '&page=1">' . $forum_section_names['section_name'] . '</a>'
                . '<p class="crumb">></p><p class="crumb">Создание темы</p>';
            ?>
        </div>
        <div class="create-theme">
            <div class="create-theme-head">
                <p style="color: white; font-family: Roboto-Light;">Создать тему</p>
            </div>
            <div class="create-theme-body">
                <form class="form-create-theme" action="/vendor/create_new_theme.php" method="POST" enctype="multipart/form-data">
                    <p class="create-theme-input-p">Заголовок темы</p>
                    <input minlength="1" maxlength="150" id="inputname" class="create-theme-input" type="text" name="name" placeholder="Введите текст" required>
                    <p style="margin: 0; font-size: 12px;" id="leftsimbolsname">Использовано 0 из 150 доступных символов</p>
                    <p class="create-theme-input-p">Сообщение</p>
                    <textarea minlength="1" maxlength="1000" id="answerarea" class="create-theme-input-body" type="textarea" name="body" placeholder="Введите текст" required></textarea><br>
                    <input type="hidden" name="section" value=<?php echo $section_id; ?>>
                    <p style="margin: 0; font-size: 12px;" id="leftsimbolsarea">Использовано 0 из 1000 доступных символов</p>
                    <input style="margin-top: 10px;" name="userfile[]" type="file" accept=".jpg, .png, .jpeg|image/*" multiple><br>
                    <input class="create-theme-form-button" type="submit" value="Создать">
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
<script src="js/textarea.js"></script>
</html>