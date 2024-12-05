<?php
include('./source.php');
include('../info_db_.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    
    if ($director_pass != $result['director_pass']) {
        $dbh = null;
        header('Location: ../error.php?type=24', true, 307);
        exit;
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>スタンプ登録</title>
        <meta name = "description" content = "スタンプ登録">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/form7.css" rel = "stylesheet">
        <script src = "./js/set-stamp.js"></script>
        <script src = "./js/set-img-button.js"></script>
        <script src = "./js/slide-stamp.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>
        <main class = "main">
            <div class = "main-inner">
                <h1>スタンプ登録</h1>
                <form class = "main-inner-form-stamp" method = "POST" enctype = "multipart/form-data" action = "make_stamp.php">
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name ?>">

                    <p class = "main-inner-form-title">タイトル：<input type = "text" name = "img_title" required></p>

                    <div class = "main-inner-form-type">
                        <div><p>タイプ　：</p></div>
                        <div class = "main-inner-form-type-radio">
                            <div><p><input class = "radio-normal" type = "radio" name = "stamp_style" value = "1" checked>通常</p></div>
                            <div><p><input class = "radio-random" type = "radio" name = "stamp_style" value = "2">ガチャ</p></div>
                        </div>
                    </div>
                    
                    <p class = "main-inner-form-limit">有効期限：<input type = "date" name = "date_limit" required></p>

                    <hr class = "main-inner-form-line">

                    <div class = "stamp-normal">
                        <div class = "form-img-box">
                            <p>スタンプ：</p>
                            <button class = "stamp-normal-img-button" type = "button">ファイルを選択</button>
                        </div>
                        <img class = "stamp-normal-img-preview" src = "./images/preview-back.png">
                    </div>

                    <div class = "stamp-random" style = "display: none;">
                        <div class = "stamp-random-area">
                            <button class = "stamp-random-left" type = "button">〈</button>
                            <div class = "stamp-random-panel">
                                <div class = "stamp-prob-title-0">
                                    <div class = "form-img-box">
                                        <p class = "stamp-subtitle-0">スタンプ１：</p>
                                        <button class = "stamp-img-0-button" type = "button">ファイルを選択</button>
                                    </div>
                                    <div class = "stamp-prob-0"><p>確率(%)：<input class = "stamp-prob-0-data" type = "number" name = "prob_data_0"><p></div>
                                    <img class = "stamp-normal-img-preview-0" src = "./images/preview-back.png">
                                </div>

                                <div class = "stamp-prob-title-1">
                                    <div class = "form-img-box">
                                        <p class = "stamp-subtitle-1">スタンプ２：</p>
                                        <button class = "stamp-img-1-button" type = "button">ファイルを選択</button>
                                    </div>
                                    <div class = "stamp-prob-1"><p>確率(%)：<input class = "stamp-prob-1-data" type = "number" name = "prob_data_1"><p></div>
                                    <img class = "stamp-normal-img-preview-1" src = "./images/preview-back.png">
                                </div>

                                <div class = "stamp-prob-title-2">
                                    <div class = "form-img-box">
                                        <p class = "stamp-subtitle-2">スタンプ３：</p>
                                        <button class = "stamp-img-2-button" type = "button">ファイルを選択</button>
                                    </div>
                                    <div class = "stamp-prob-2"><p>確率(%)：<input class = "stamp-prob-2-data" type = "number" name = "prob_data_2"><p></div>
                                    <img class = "stamp-normal-img-preview-2" src = "./images/preview-back.png">
                                </div>

                                <div class = "stamp-prob-title-3">
                                    <div class = "form-img-box">
                                        <p class = "stamp-subtitle-3">スタンプ４：</p>
                                        <button class = "stamp-img-3-button" type = "button">ファイルを選択</button>
                                    </div>
                                    <div class = "stamp-prob-3"><p>確率(%)：<input class = "stamp-prob-3-data" type = "number" name = "prob_data_3"><p></div>
                                    <img class = "stamp-normal-img-preview-3" src = "./images/preview-back.png">
                                </div>

                                <div class = "stamp-prob-title-4">
                                    <div class = "form-img-box">
                                        <p class = "stamp-subtitle-4">スタンプ５：</p>
                                        <button class = "stamp-img-4-button" type = "button">ファイルを選択</button>
                                    </div>
                                    <div class = "stamp-prob-4"><p>確率(%)：<input class = "stamp-prob-4-data" type = "number" name = "prob_data_4"><p></div>
                                    <img class = "stamp-normal-img-preview-4" src = "./images/preview-back.png">
                                </div>
                            </div>
                            <button class = "stamp-random-right" type = "button">〉</button>
                        </div>
                        
                        <div class = "stamp-random-count">
                            <button class = "stamp-random-count0" type = "button" style = "display: block;"></button>
                            <button class = "stamp-random-count1" type = "button" style = "display: block;"></button>
                            <button class = "stamp-random-count2" type = "button" style = "display: none;"></button>
                            <button class = "stamp-random-count3" type = "button" style = "display: none;"></button>
                            <button class = "stamp-random-count4" type = "button" style = "display: none;"></button>
                        </div>

                        <div class = "stamp-random-set">
                            <button class = "stamp-random-add" type = "button">＋</button>
                            <button class = "stamp-random-remove" type = "button">−</button>
                        </div>

                        <p class = "stamp-random-notice">※スタンプ画像は、最大５つまで登録可能です。確率は整数値で設定してください。</p>
                        <p class = "stamp-random-alert" style = "display: none;"></p>
                    </div>
                    
                    <div class = "stam-submit-block">
                        <input class = "stamp-normal-img" type = "file" name = "img_data" accept = "image/*" required>
                        <input class = "stamp-img-0" type = "file" name = "img_data_0" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-1" type = "file" name = "img_data_1" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-2" type = "file" name = "img_data_2" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-3" type = "file" name = "img_data_3" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-4" type = "file" name = "img_data_4" accept = "image/*" style = "display: none">
                        <div class = "stamp-submit-block-back"></div>
                        <input class = "stamp-submit-button" type = "submit" value = "登録">
                    </div>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
