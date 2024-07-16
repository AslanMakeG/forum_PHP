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
    <link href="css/create_theme.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <title>Курсовая</title>
    <script src="js/dropdown.js"></script>
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
                $theme_id = $_GET['theme_id'];

                $section_query = mysqli_query($connect, 
                "SELECT *
                FROM `themes`
                WHERE `id` = '$theme_id'");

                $section_result = mysqli_fetch_assoc($section_query);
                $section_id = $section_result['section_id'];
                
                $forum_section_query = mysqli_query($connect, 
                "SELECT `forums`.`name` forum_name, `sections`.`name` section_name, `sections`.`id` section_id
                FROM `sections` LEFT JOIN `forums`
                ON `forums`.`id` = `sections`.`forum_id`
                WHERE `sections`.`id` = '$section_id'");

                $forum_section_names = mysqli_fetch_assoc($forum_section_query);

                $theme_query = mysqli_query($connect, 
                "SELECT `themes`.`name` name, `themes`.`id` id, `themes`.`body` body, `themes`.`date` date, `themes`.`time` time, 
                `themes`.`status` status, `users`.`login` author, `users`.`id` author_id,
                `users`.`date_register` author_date_register, `users`.`avatar` author_avatar
                FROM `themes` JOIN `users`
                ON `themes`.`user_id` = `users`.`id`
                WHERE `themes`.`id` = '$theme_id'");

                $theme = mysqli_fetch_assoc($theme_query);

                echo '<a class="crumb" href="index.php">' . $forum_section_names['forum_name'] . '</a>'
                . '<p class="crumb">></p>' 
                . '<a class="crumb" href="section.php?id=' . $section_id . '&page=1">' . $forum_section_names['section_name'] . '</a>'
                . '<p class="crumb">></p>' 
                . '<a class="crumb">' . $theme['name'] . '</a>';
            ?>
        </div>
        <?php
            if($_SESSION['user']['id'] == $theme['author_id'] || $_SESSION['user']['role'] == 'admin'){
                echo '<div class="create-theme-form">
                        <input class="create-theme-button" type="button" data-theme="' . $theme_id . '" onclick="deleteTheme(event)" value="Удалить тему">';
                if($theme['status'] == 'open'){
                    echo '<a style="margin-right: 30px;" href="vendor/open_close_theme.php?status=close&theme_id=' . $theme_id . '"><input class="create-theme-button" type="button" value="Закрыть тему"></a>';
                }
                else{
                    echo '<a style="margin-right: 30px;" href="vendor/open_close_theme.php?status=open&theme_id=' . $theme_id . '"><input class="create-theme-button" type="button" value="Открыть тему"></a>';
                }
                echo '</div>';
            }
        ?>
        <div class="theme-main">
            <div class="theme-head">
                <?php
                    if(isset($_SESSION['user'])){
                        $user_id = $_SESSION['user']['id'];
                        $favourite_theme_query = mysqli_query($connect, 
                        "SELECT * 
                        FROM `favourite_themes`
                        WHERE `user_id` = '$user_id' AND `theme_id` = '$theme_id'");
                        
                        if(mysqli_num_rows($favourite_theme_query) > 0){
                            echo '<a href="vendor/favourite.php?theme_id=' . $theme_id . '&page=' . $page . '"><img src="img/delete_favourite.png" width="25" height="25"></a>';
                        }
                        else{
                            echo '<a href="vendor/favourite.php?theme_id=' . $theme_id . '&page=' . $page . '"><img src="img/add_favourite.png" width="25" height="25"></a>';
                        }
                    }
                ?>
            </div>
            <div class="theme-body">
                <?php

                    $answers_query = mysqli_query($connect,
                    "SELECT`answers`.`id` id, `answers`.`body` body, `answers`.`date` date, 
                    `answers`.`time` time, `users`.`login` author, 
                    `users`.`date_register` author_date_register, `users`.`avatar` author_avatar
                    FROM `answers` JOIN `users` 
                    ON`answers`.`user_id` = `users`.`id`
                    WHERE `answers`.`theme_id` = '$theme_id'
                    ORDER BY `answers`.`date` ASC, `answers`.`time` ASC");

                    $result_per_page = 10;

                    $total_pages = ceil((mysqli_num_rows($answers_query) + 1) / $result_per_page);

                    if($page > $total_pages){
                        $page = $total_pages;
                    }

                    if($page < 1){
                        $page = 1;
                    }

                    if($page < 2){

                        $theme_id = $theme['id'];
                        $images_query = mysqli_query($connect, 
                        "SELECT `theme_images`.`image` image, `theme_images`.`id` id, `themes`.`user_id` user_id FROM `theme_images` 
                        JOIN `themes` ON `theme_images`.`theme_id` = `themes`.`id` 
                        WHERE `theme_id` = '$theme_id'");

                        echo '
                            <div class="theme theme-answer">
                            <div class="theme-author">
                                <a class="theme-author-author" href="user.php?id=' . $theme['author_id'] . '">' . $theme['author'] . '</a>
                                <p class="theme-author-date" style="margin-bottom: 0;">Регистрация </p> 
                                <p class="theme-author-date" style="margin-top: 0;">' . $theme['author_date_register'] . '</p>';
                        
                        if($theme['author_avatar'] == ''){
                            echo '<div id="user-avatar1">
                            <img style="cursor: default;!important" width="50" height="50" src="img/noavatar.png">
                            </div>';
                        }
                        else{
                            echo '<div id="user-avatar1">
                                <img style="cursor: default;!important" class="image-answer1" width="50" height="50"
                                src="data:image/png;base64,'.base64_encode($theme['author_avatar']).'">
                            </div>';
                        }

                        echo '</div>
                            <div class="theme-title">
                                <p class="theme-title-name">' . $theme['name'] . '</p>
                                <p class="theme-answer-body">' . $theme['body'] . '</p>';

                        if(mysqli_num_rows($images_query) > 0){
                            echo '<div class="answer-images">';
                            while($image = mysqli_fetch_assoc($images_query)){
                                echo '
                                <div class="image-content">
                                    <div>
                                        <img class="image-answer" width="400"  
                                        onclick="showImage(event)" src="data:image/png;base64,'.base64_encode($image['image']).'">
                                    </div>';
                                if(($theme['status'] != 'close' && $_SESSION['user']['id'] == $image['user_id']) || $_SESSION['user']['role'] == 'admin'){
                                    echo '<button class="delete-image-button" data-imageid="' . $image['id'] .'" onclick="deleteImage(event, `theme`)"></button>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }

                        if(($theme['status'] != 'close' && $theme['author'] == $_SESSION['user']['login']) || $_SESSION['user']['role'] == 'admin'){
                            echo '<div class="userButtons">
                                    <button class="edit-button" data-theme="' . $theme['id'] . '" onclick="editTheme(event)"></button>
                                </div>
                            ';
                        } 

                        echo '</div>
                            <div class="theme-datetime">
                                <p class="theme-p">' . $theme['date'] . '</p>
                                <p class="theme-p" style="margin-top: 0;">в ' . $theme['time'] . '</p>
                            </div>
                        </div>
                        ';

                        $result_per_page_1 = $result_per_page - 1;
                        $answers_query = mysqli_query($connect,
                        "SELECT`answers`.`id` id, `answers`.`body` body, `answers`.`date` date, `answers`.`time` time, 
                        `answers`.`user_id` author_id, `users`.`login` author, 
                        `users`.`date_register` author_date_register, `users`.`avatar` author_avatar
                        FROM `answers` JOIN `users` 
                        ON`answers`.`user_id` = `users`.`id`
                        WHERE `answers`.`theme_id` = '$theme_id'
                        ORDER BY `answers`.`date` ASC, `answers`.`time` ASC
                        LIMIT 0, $result_per_page_1");
                    }
                    else{
                        $start_row = (($page - 1) * $result_per_page) - 1;
                        $answers_query = mysqli_query($connect,
                        "SELECT`answers`.`id` id, `answers`.`body` body, `answers`.`date` date, `answers`.`time` time, 
                        `answers`.`user_id` author_id, `users`.`login` author, 
                        `users`.`date_register` author_date_register, `users`.`avatar` author_avatar
                        FROM `answers` JOIN `users` 
                        ON`answers`.`user_id` = `users`.`id`
                        WHERE `answers`.`theme_id` = '$theme_id'
                        ORDER BY `answers`.`date` ASC, `answers`.`time` ASC
                        LIMIT $start_row, $result_per_page");
                    }

                    while($row = mysqli_fetch_assoc($answers_query)){
                        $answer_id = $row['id'];
                        echo '
                            <div class="theme theme-answer">
                                <div class="theme-author">
                                    <a class="theme-author-author" href="user.php?id=' . $row['author_id'] . '">' . $row['author'] . '</a>
                                    <p class="theme-author-date" style="margin-bottom: 0;">Регистрация </p> 
                                    <p class="theme-author-date" style="margin-top: 0;">' . $row['author_date_register'] . '</p>';

                        if($row['author_avatar'] == ''){
                            echo '<div id="user-avatar1">
                            <img style="cursor: default;!important" width="50" height="50" src="img/noavatar.png">
                            </div>';
                        }
                        else{
                            echo '<div id="user-avatar1">
                                <img style="cursor: default;!important" class="image-answer1" width="50" height="50"
                                src="data:image/png;base64,'.base64_encode($row['author_avatar']).'">
                            </div>';
                        }      

                        echo  '</div>
                                <div class="theme-title answer-theme">
                                    <pre class="pre-p"><p class="theme-answer-body">' . $row['body'] . '</p></pre>';

                        $images_query = mysqli_query($connect, 
                        "SELECT `answer_images`.`image` image, `answer_images`.`id` id, `answers`.`user_id` user_id FROM `answer_images` 
                        JOIN `answers` ON `answer_images`.`answer_id` = `answers`.`id` 
                        WHERE `answer_id` = '$answer_id'");
                        
                        if(mysqli_num_rows($images_query) > 0){
                            echo '<div class="answer-images">';
                            while($image = mysqli_fetch_assoc($images_query)){
                                echo '
                                <div class="image-content">
                                    <div>
                                        <img class="image-answer" width="400"  
                                        onclick="showImage(event)" src="data:image/png;base64,'.base64_encode($image['image']).'">
                                    </div>';
                                if(($theme['status'] != 'close' && $_SESSION['user']['id'] == $image['user_id']) || $_SESSION['user']['role'] == 'admin'){
                                    echo '<button class="delete-image-button" data-imageid="' . $image['id'] .'" onclick="deleteImage(event, `answer`)"></button>';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        }


                        if(($theme['status'] != 'close' && $row['author'] == $_SESSION['user']['login']) || $_SESSION['user']['role'] == 'admin'){
                            echo '<div class="userButtons">
                                    <button class="edit-button" data-answer="' . $answer_id . '" onclick="editAnswer(event)"></button>
                                    <button class="delete-button" data-answer="' . $answer_id . '" onclick="deleteAnswer(event)"></button>
                                </div>
                            ';
                        }
                        
                        echo '</div>
                                <div class="theme-datetime">
                                    <p class="theme-p">' . $row['date'] . '</p>
                                    <p class="theme-p" style="margin-top: 0;">в ' . $row['time'] . '</p>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
            <?php
                echo '<div class="pagination">';
                if($total_pages > 0){
                    echo '<p class="pagination-page">Страница ' . $page . ' из ' . $total_pages . '</p>';
                }
                echo '<div class="pagination-buttons">';
                if($page > 1){
                    echo '<a href="theme.php?theme_id=' . $_GET['theme_id'] . '&page=1">
                        <input class="create-theme-button" style="min-width: 32px; width: 32px;" type="button" value="<<"></a>
                    <a style="margin-right: 10px;" href="theme.php?theme_id=' . $_GET['theme_id'] . '&page=' . ($page - 1) . '"><input class="create-theme-button" type="button" value="Назад"></a>';
                }
                if($page < $total_pages){
                    echo '<a href="theme.php?theme_id=' . $_GET['theme_id'] . '&page=' . ($page + 1) . '"><input class="create-theme-button" type="button" value="Далее"></a>
                    <a href="theme.php?theme_id=' . $_GET['theme_id'] . '&page=' . $total_pages . '">
                        <input class="create-theme-button" style="min-width: 32px; width: 32px;" type="button" value=">>">
                    </a>';
                }
            
                echo'</div>
                </div>';

            ?>
        </div>
        <?php
            if($theme['status'] == 'close'){
                return;
            }

            if(isset($_SESSION['user'])){
                echo '
                <div class="create-theme">
                    <div class="create-theme-head">
                        <p style="color: white; font-family: Roboto-Light;">Ответить</p>
                    </div>
                    <div class="create-theme-body">
                        <form class="form-create-theme" action="/vendor/answer_to_theme.php" method="POST" enctype="multipart/form-data">
                            <textarea minlength="1" maxlength="1000" id="answerarea" class="create-theme-input-body" type="textarea" name="body" placeholder="Введите текст" required></textarea><br>
                            <input type="hidden" name="section" value="' . $section_id . '">
                            <input type="hidden" name="theme" value="' . $theme_id . '">
                            <input type="hidden" name="page" value="' . $page . '">
                            <p style="margin: 0; font-size: 12px;" id="leftsimbols">Использовано 0 из 1000 доступных символов</p>
                            <input style="margin-top: 10px;" name="userfile[]" type="file" accept=".jpg, .png, .jpeg|image/*" multiple><br>
                            <input class="create-theme-form-button" type="submit" value="Ответить">
                        </form>
                    </div>
                </div>
            ';
            }
            else{
                echo '<p style="margin-top: 10px;">Авторизуйтесь, чтобы иметь возможность ответить на тему</p>';
            }
        ?>
    </div>
    <div id="modal">
        <div class="shadow"></div>
        <div class="window">
        <p id="modalMessage">Вы действительно хотите удалить этот ответ?</p>
                <form id="modalForm" class="modal-buttons" action="vendor/delete_answer.php" method="POST">
                    <input id="hiddenModal" type="hidden" name="id" value="">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                    <input class="modal-button"  type="submit" value="Да">
                    <input class="modal-button" type="button" onclick="closeModal(event)" value="Отмена">
                </form>
        </div>
    </div>

    <div id="modal2">
        <div class="shadow2"></div>
        <div class="window2">
        <button class="close-image-button" onclick="closeImage(event)"></button>
            <img id="modalImage">
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
<script src="js/modal.js"></script>
<script src="js/dance_image.js"></script>
<script src="js/textarea.js"></script>
</html>