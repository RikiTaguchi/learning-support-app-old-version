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

    $sql = 'SELECT * FROM ' . $my_list_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $table_feedback = $table_id . '_feedback';
    $sql = 'SELECT * FROM ' . $table_feedback;
    $stmt = $dbh->query($sql);
    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $list_feedback = [];
    foreach ($result2 as $row) {
        if (in_array($row['book_name'], $list_feedback) == false) {
            $list_feedback[] = $row['book_name'];
        }
    }

    if (count($list_feedback) == 0) {
        header('Location: https://wordsystemforstudents.com/error.php?type=3', true, 307);
        exit;
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
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
            <?php
            include('./header.php');
            ?>
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
                            <select class = "main-form-book" name = "book_name" required id="mySelect">
                                <option value = "n" hidden>選択してください</option>
                                <?php
                                if (in_array('target_1400', $list_feedback)) {
                                    echo '<option value = "1">ターゲット1400</option>';
                                }
                                if (in_array('target_1900', $list_feedback)) {
                                    echo '<option value = "2">ターゲット1900</option>';
                                }
                                if (in_array('system_English', $list_feedback)) {
                                    echo '<option value = "3">システム英単語</option>';
                                }
                                if (in_array('rapid_Reading', $list_feedback)) {
                                    echo '<option value = "4">速読英熟語(熟語)</option>';
                                }
                                if (in_array('Vintage', $list_feedback)) {
                                    echo '<option value = "5">Vintage</option>';
                                }
                                if (in_array('pass_3', $list_feedback)) {
                                    echo '<option value = "6">パス単(3級)</option>';
                                }
                                if (in_array('pass_pre2', $list_feedback)) {
                                    echo '<option value = "7">パス単(準２級)</option>';
                                }
                                if (in_array('pass_2', $list_feedback)) {
                                    echo '<option value = "8">パス単(２級)</option>';
                                }
                                if (in_array('pass_pre1', $list_feedback)) {
                                    echo '<option value = "9">パス単(準１級)</option>';
                                }
                                if (in_array('pass_1', $list_feedback)) {
                                    echo '<option value = "10">パス単(１級)</option>';
                                }
                                if (in_array('get_Through_2600', $list_feedback)) {
                                    echo '<option value = "11">ゲットスルー2600</option>';
                                }
                                if (in_array('meiko_original_1', $list_feedback)) {
                                    echo '<option value = "12">明光暗記テキスト(単語)</option>';
                                }
                                if (in_array('meiko_original_2', $list_feedback)) {
                                    echo '<option value = "13">明光暗記テキスト(文法)</option>';
                                }
                                if (in_array('gold_phrase', $list_feedback)) {
                                    echo '<option value = "14">TOEIC金のフレーズ</option>';
                                }
                                if (in_array('kobun300', $list_feedback)) {
                                    echo '<option value = "15">みるみる古文単語300</option>';
                                }
                                if (in_array('kobun315', $list_feedback)) {
                                    echo '<option value = "16">古文単語315</option>';
                                }
                                if (in_array('kobun330', $list_feedback)) {
                                    echo '<option value = "17">古文単語330</option>';
                                }
                                ?>
                                <?php
                                foreach ($result as $row) {
                                    if (in_array($table_id . '_' . $row['book_id'], $list_feedback)) {
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
            <?php
            include('./footer.php');
            ?>
        </footer>
    </body>
</html>
