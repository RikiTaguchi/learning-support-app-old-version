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
    
    // 復習リストの取得
    $sql = 'SELECT * FROM info_feedback WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $list_feedback = [];
    foreach ($result2 as $row) {
        if (in_array($row['book_id'], $list_feedback) == false) {
            $list_feedback[] = $row['book_id'];
        }
    }

    if (count($list_feedback) == 0) {
        header('Location: error.php?type=3', true, 307);
        exit;
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
        <title>復習モード</title>
        <meta name = "description" content = "復習モード入力フォーム">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/form.css" rel = "stylesheet">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <script src = "./js/toggle-menu.js"></script>
        <script src = "./js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">復習モード</p>
                <form  class = "main-form" method = "post" action = "feedback.php">
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
                                set_options_feedback($list_feedback);
                                foreach ($result as $row) {
                                    if (in_array($row['book_id'], $list_feedback)) {
                                        echo '<option value = "' . $row['book_id'] . '">' . $row['book_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p class = "main-form-style">
                            出題形式：
                            <span class = "main-form-style-inner">
                                <span><input type = "radio" name = "order" value = "1" checked>ランダム</span>
                                <span><input type = "radio" name = "order" value = "2">番号順</span>
                            </span>
                        </p>
                        <p class = "main-form-submit"><input type = "submit" value = "開始"></p>
                    </div>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
