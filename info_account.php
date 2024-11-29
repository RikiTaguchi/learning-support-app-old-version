<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $login_id = $result['login_id'];
    $user_pass = $result['user_pass'];
    $user_name = $result['user_name'];
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

include('./banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>アカウント情報</title>
        <meta name = "description" content = "単語システムアカウント情報">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/info.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/set-banner.js"></script>
        <script src = "./js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <?php if ($login_id != '000000') { ?>
                <h1>アカウント情報</h1>
                <div class = "main-info-account">
                    <div class = "main-info-account-inner">
                        <form class = "main-info-form" method = "post" action = "edit_account.php">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                ?>
                                <p class = "main-info-form-text">ユーザーネーム</p>
                                <?php echo '<input type = "text" name = "new_user_name" value = "' . $user_name . '" required>' ?>
                                <p class = "main-info-form-text">ユーザーID</p>
                                <?php echo '<input type = "text" name = "new_login_id" value = "' . $login_id . '" required>' ?>
                                <p class = "main-info-form-text">パスワード</p>
                                <?php echo '<input type = "text" name = "new_user_pass" value = "' . $user_pass . '" required>' ?>
                                <br>
                            </div>
                            <div class = "main-info-button">
                                <button type = "submit">
                                    <p>変更する</p>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class = "main-info-account-delete">
                        <form method = "post" action = "delete_account.php" onSubmit = "return checkSubmit()">
                            <div>
                                <?php
                                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                                ?>
                                <button class = "delete-text" type = "submit">
                                    <p>削除する</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
