<?php
include('./source.php');
include('./info_db.php');
include('./source_book.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    // MyBookリストの取得
    if ($login_id != '000000' && $user_pass != '569452' && $user_name != 'ゲスト') {
        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = :table_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

include('./banner.php');
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>単語テスト作成</title>
        <meta name = "description" content = "単語テスト作成入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/form.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/toggle-index.js"></script>
        <script src = "./js/toggle-index-change.js"></script>
        <script src = "./js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">テスト作成</p>

                <?php include('./index_menu.php'); ?>

                <form  class = "main-form" method = "post" action = "set.php">
                    <div class = "main-form-inner">
                        <?php
                        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                        ?>
                        <p>
                            参考書　：
                            <select class = "main-form-book" name = "book_id" required id="mySelect">
                                <?php
                                echo set_options();
                                if ($login_id != '000000') {
                                    foreach ($result as $row) {
                                        echo '<option value = "' . $row['book_id'] . '">' . $row['book_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p>開始番号：<input class = "main-form-start" type = "number" name = "start" required></p>
                        <p>終了番号：<input class = "main-form-end" type = "number" name = "end" required></p>
                        <p class = "main-form-style">
                            出題形式：
                            <span class = "main-form-style-inner">
                                <span><input type = "radio" name = "order" value = "1" checked>ランダム</span>
                                <span><input type = "radio" name = "order" value = "2">番号順</span>
                            </span>
                        </p>
                        <p>出題数　：<input class = "main-form-number" type = "number" name = "questions_num" required></p>
                        <p class = "main-form-submit"><input type = "submit" value = "作成"></p>
                    </div>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
