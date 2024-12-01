<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>構文解析</title>
        <meta name = "description" content = "構文解析入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/form5.css" rel = "stylesheet">
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
                <p class = "main-title">英文解析</p>
                <form  class = "main-form" method = "post" action = "generate.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "main-form-inner">
                        <p class = "main-form-title">英文を入力</p>
                        <textarea class = "main-form-text" name = "text" required></textarea>
                        <p class = "main-form-submit"><input type = "submit" value = "送信"></p>
                        <p class = "main-form-inform">※解析には数十秒かかる場合があります。<br>※各文は改行で区切ってください。</p>
                    </div>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
