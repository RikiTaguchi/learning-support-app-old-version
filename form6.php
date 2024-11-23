<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $my_list_id = $table_id . '_my_book_list';
    $api_key = $result['api_key'];
    
    if ($login_id != '000000' && $user_pass != '569452' && $user_name != 'ゲスト') {
        $sql = 'SELECT * FROM ' . $my_list_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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
        <title>英作文添削</title>
        <meta name = "description" content = "英作文添削入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/form6.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php
            include('./header.php');
            ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">英作文添削</p>
                <form  class = "main-form" method = "post" action = "writing.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    ?>
                    <div class = "main-form-inner">
                        <p class = "main-form-title">API Key</p>
                        <?php
                        echo '<input class = "main-form-apikey" type = "text" name = "apikey" value = "' . $api_key . '" required>';
                        ?>

                        <p class = "main-form-title">問題</p>
                        <textarea class = "main-form-question" name = "question" required></textarea>
                        
                        <p class = "main-form-title">指定語数（目安）</p>
                        <input class = "main-form-count" type = "number" name = "count" required>

                        <p class = "main-form-title">解答</p>
                        <textarea class = "main-form-answer" name = "answer" required></textarea>
                        
                        <p class = "main-form-submit"><input type = "submit" value = "送信"></p>
                        <p class = "main-form-inform">※解析には数十秒かかる場合があります。</p>
                    </div>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>
