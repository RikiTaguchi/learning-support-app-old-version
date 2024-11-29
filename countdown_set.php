<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>カウントダウン</title>
        <meta name = "description" content = "カウントダウン更新">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/countdown.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <?php if ($login_id != '000000') { ?>
                <h1>カウントダウン</h1>
                <div class = "main-edit-countdown">
                    <div class = "main-edit-countdown-inner">
                        <form class = "main-edit-countdown-form" method = "post" action = "countdown_edit.php">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                echo '<p class = "main-edit-countdown-title">タイトル</p>';
                                echo '<input class = "main-edit-countdown-subtitle" type = "text" name = "user_title" value = "' . $user_countdown_title . '"><br>';
                                echo '<p class = "main-edit-countdown-title">日程</p>';
                                echo '<input class = "main-edit-countdown-subtitle" type = "date" name = "user_date" value = "' . date('Y-m-d', $user_countdown_date) . '">';
                                ?>
                                <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                            </div>
                            <div class = "main-edit-countdown-button">
                                <button type = "submit" name = "edit_type" value = "edit">
                                    <p>更新する</p>
                                </button>
                            </div>
                        </form>
                        <form class = "main-edit-countdown-form" method = "post" action = "countdown_edit.php">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                ?>
                                <input class = "info-banner" type = "text" name = "info_banner" value = "update" style = "display: none;">
                            </div>
                            <div class = "main-edit-countdown-button-delete">
                                <button type = "submit" name = "edit_type" value = "reset">
                                    <p>リセット</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
