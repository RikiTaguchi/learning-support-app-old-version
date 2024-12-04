<?php
include('./source.php');
include('../info_db_.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    if ($director_pass != $result['director_pass']) {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
        exit;
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}

include('../banner.php');
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>テスト作成</title>
        <meta name = "description" content = "テスト作成">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/form9.css" rel = "stylesheet">
        <script src = "./js/toggle-index.js"></script>
        <script src = "./js/toggle-index-change.js"></script>
        <script src = "./js/set-banner.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>

        <main class = "main">
            <div class = "main-inner">
                <p class = "main-title">テスト作成</p>

                <?php include('../index_menu.php'); ?>

                <form class = "main-form-inner" method = "POST" action = "set2.php">
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name ?>">

                    <p>
                        参考書　：
                        <select class = "main-form-book" name = "book_name" required id="mySelect">
                            <option value = "n" hidden>選択してください</option>
                            <option value = "1">ターゲット1400</option>
                            <option value = "2">ターゲット1900</option>
                            <option value = "3">システム英単語</option>
                            <option value = "4">速読英熟語(熟語)</option>
                            <option value = "5">Vintage</option>
                            <option value = "6">パス単(３級)</option>
                            <option value = "7">パス単(準２級)</option>
                            <option value = "8">パス単(２級)</option>
                            <option value = "9">パス単(準１級)</option>
                            <option value = "10">パス単(１級)</option>
                            <option value = "11">ゲットスルー2600</option>
                            <option value = "12">明光暗記テキスト(単語)</option>
                            <option value = "13">明光暗記テキスト(文法)</option>
                            <option value = "14">TOEIC金のフレーズ</option>
                            <option value = "15">みるみる古文単語300</option>
                            <option value = "16">古文単語315</option>
                            <option value = "17">古文単語330</option>
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
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
