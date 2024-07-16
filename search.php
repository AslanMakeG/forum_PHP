<?php
    session_start();
    require_once 'vendor/connect.php';
    $page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
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
            <p class="crumb">Поиск</p>
        </div>

        <?php

            $user_query = $_GET['search_themes'];

            $themes_query = mysqli_query($connect, 
            "SELECT * FROM `themes` 
            WHERE `name` LIKE '%$user_query%'
            ORDER BY `date_last_answer` DESC, `time_last_answer` DESC");

            echo '
            <div class="section">
                <div class="section-head">
                    <p class="section-head-title">Результаты поиска для: ' . $user_query . '</p>
                </div>
                <div class="section-body">';
            
            $result_per_page = 10;
            $total_pages = ceil(mysqli_num_rows($themes_query) / $result_per_page);

            if($page > $total_pages){
                $page = $total_pages;
            }

            if($page < 1){
                $page = 1;
            }

            if($page < 2){
                $themes_query = mysqli_query($connect, 
                "SELECT * FROM `themes` 
                WHERE `name` LIKE '%$user_query%'
                ORDER BY `date_last_answer` DESC, `time_last_answer` DESC
                LIMIT 0, $result_per_page");
            }
            else{
                $start_row = ($page - 1) * $result_per_page;
                $themes_query = mysqli_query($connect, 
                "SELECT * FROM `themes` 
                WHERE `name` LIKE '%$user_query%'
                ORDER BY `date_last_answer` DESC, `time_last_answer` DESC
                LIMIT $start_row, $result_per_page");
            }
                
            if(mysqli_num_rows($themes_query) > 0){
                while($row = mysqli_fetch_assoc($themes_query)){
                    echo '<div class="theme">
                        <div class="section-theme-status">';
    
                    if($row['status'] == 'open'){
                        echo '<img src="img/status_open.png" width="32" heigth="32">';
                    }
                    else{
                        echo '<img src="img/status_close.png" width="32" heigth="32">';
                    }
    
                    echo    '</div>
                        <div class="section-theme-title">
                            <a class="section-theme-title-name" href="theme.php?theme_id=' . $row['id'] . '">
                                <p class="section-theme-title-name">' . $row['name'] . '</p>
                            </a>
                            <p class="section-theme-title-date">Создана: ' . $row['date'] . '</p>
                        </div>
                        <div class="section-theme-answers">
                            <p class="section-theme-p">Ответов:</p>
                            <p class="section-theme-p">' . $row['amount_answers'] . '</p>
                        </div>
                        <div class="section-theme-last">
                            <p class="section-theme-p">Последний ответ:</p>
                            <p class="section-theme-p">' . $row['date_last_answer'] . '</p>
                            <p class="section-theme-p" style="margin-top: 0;">' . $row['time_last_answer'] . '</p>
                        </div>
                    </div>';
                }    
            }
            else{
                echo '<div class="theme">
                        <p style="margin-left: 10px" class="section-theme-title-name">Ничего не найдено</p>
                    </div>';
            }
            echo '</div>
            </div>
            ';
        ?>

        <?php
            echo '<div class="pagination">';

            if($total_pages > 0){
                echo '<p class="pagination-page">Страница ' . $page . ' из ' . $total_pages . '</p>';
            }
            echo '<div class="pagination-buttons">';
            if($page > 1){
                echo '<a style="margin-right: 10px;" href="search.php?search_themes=' . $_GET['search_themes'] . '&page=' . ($page - 1) . '"><input class="create-theme-button" type="button" value="Назад"></a>';
            }
            if($page < $total_pages){
                echo '<a href="search.php?search_themes=' . $_GET['search_themes'] . '&page=' . ($page + 1) . '"><input class="create-theme-button" type="button" value="Далее"></a>';
            }
           
            echo'</div>
            </div>';

        ?>     
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
</html>