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
    <link href="css/forum.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
    <link href="css/dropdown.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
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
            <p class="crumb">Профиль</p>
        </div>
        <div class="profile-content">
            <div class="profile">
                <div class="profile-head">
                    <p style="color: white; font-family: Roboto-Light;"><?php echo $_SESSION['user']['login']; ?></p>
                </div>
                <form id="profile-body" class="profile-body" action="vendor/edit_profile.php" method="POST"  enctype="multipart/form-data">
                    <?php
                        $user_id = $_SESSION['user']['id'];
                        $user_query = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id'");

                        $user = mysqli_fetch_assoc($user_query);

                        if($user['avatar'] == ''){
                            echo '<div id="user-avatar" class="user-avatar-border2">
                            <img style="cursor: default;!important" width="200" height="200" src="img/noavatar.png">
                            </div>';
                        }
                        else{
                            echo '<div id="user-avatar" class="user-avatar-border2">
                                <img style="cursor: default;!important" class="image-answer" width="200" height="200"
                                src="data:image/png;base64,'.base64_encode($user['avatar']).'">
                            </div>';
                        }

                        echo '
                            <div id="profile-name">
                                <p class="profile-p">ФИО: </p>
                                <p style="margin-left: 3px;">' . $user['name'] .'</p>
                            </div>
                            <div id="profile-about" style="display: flex;">
                                <p class="profile-p">Обо мне: </p>';
                        if($user['about'] == ''){
                            echo '<p style="margin-left: 3px;">не заполнено</p>';
                        }
                        else{
                            echo '<p style="margin-left: 3px;">' . $user['about'] .'</p>';
                        }
                                
                        echo '</div>
                            <div id="profile-email">
                                <p class="profile-p">Email: </p>
                                <p style="margin-left: 3px;">' . $user['email'] .'</p>
                            </div>
                            <p class="profile-p">Дата регистрации: ' . $user['date_register'] .'</p>
                            <p class="profile-p">Роль: ';
                            
                        if($user['role'] == 'user'){
                            echo 'пользователь';
                        }
                        else if($user['role'] == 'admin'){
                            echo 'администратор';
                        }
                        echo '</p>
                            <p class="profile-p">Количество ответов: ' . $user['amount_answers'] .'</p>
                        ';
                    ?>
                    <button id="editButton" class="edit-button" type="button" data-userid="<?php echo $_SESSION['user']['id']; ?>" onclick="editProfile(event)"></button>
                    <div id="profileButtons">
                        <input class="create-theme-button" type="submit" value="Сохранить">
                        <button class="create-theme-button" style="margin-left: 10px;" type="button" onclick="cancelEdit(event)">Отмена</button>
                    </div>
                </form>
            </div>
            <div class="favoutite-themes">
                <div class="profile-head">
                    <p style="color: white; font-family: Roboto-Light;">Мои темы</p>
                </div>
                <div class="favoutite-themes-body">
                    <?php
                        $themes_query = mysqli_query($connect,
                        "SELECT `themes`.`id` id, `themes`.`name` name
                        FROM `themes`
                        WHERE `user_id` = '$user_id'");

                        if(mysqli_num_rows($themes_query) > 0){
                            while($row = mysqli_fetch_assoc($themes_query)){
                                echo '<a class="theme-link" href="theme.php?theme_id=' . $row['id'] .'">' . $row['name'] .'</a>';
                            }
                        }
                        else{
                            echo '<p>Вы еще не создали тем</p>';
                        }
                    ?>
                </div>
            </div>
            <div class="favoutite-themes">
                <div class="profile-head">
                    <p style="color: white; font-family: Roboto-Light;">Избранные темы</p>
                </div>
                <div class="favoutite-themes-body">
                    <?php
                        $themes_query = mysqli_query($connect,
                        "SELECT `themes`.`id` id, `themes`.`name` name
                        FROM `favourite_themes` JOIN `themes`
                        ON `favourite_themes`.`theme_id` = `themes`.`id`
                        WHERE `favourite_themes`.`user_id` = '$user_id'");

                        if(mysqli_num_rows($themes_query) > 0){
                            while($row = mysqli_fetch_assoc($themes_query)){
                                echo '<a class="theme-link" href="theme.php?theme_id=' . $row['id'] .'">' . $row['name'] .'</a>';
                            }
                        }
                        else{
                            echo '<p>Вы еще не добавили темы</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="modal">
        <div class="shadow"></div>
        <div class="window">
            <p id="modalMessage">Вы действительно хотите удалить свою аватарку?</p>
            <div>
                <input class="modal-button"  type="button" onclick="deleteAvatar(event)" value="Да">
                <input class="modal-button" type="button" onclick="closeModal(event)" value="Отмена">
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
<script src="js/edit_profile.js"></script>
</html>