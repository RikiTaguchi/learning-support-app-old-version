<?php
include('./source2.php');

$stamp_table_id = $_POST['stamp_table_id'];
$stamp_img_id = $_POST['stamp_img_id'];

$stamp_type = '';
$stamp_number = 0;
$stamp_info = [];

$stamp_title = '';
$stamp_limit = '';

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

    $sql = 'SELECT * FROM info_image WHERE table_id = \'' . $stamp_table_id . '\' AND img_id = \'' . $stamp_img_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stamp_title = $result[0]['img_title'];
    $stamp_limit = $result[0]['date_limit'];

    if ($result[0]['stamp_id'] == 'none') {
        $stamp_type = 'normal';
        $stamp_number = 1;
    } else {
        $stamp_type = 'random';
        $stamp_number = count($result);
    }

    foreach ($result as $i => $row) {
        $stamp_info[] = [$row['table_id'], $row['img_id'], $row['stamp_id'], $row['stamp_prob'], $row['img_extention']];
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head lang = "ja">
        <meta charset = "UTF-8">
        <title>スタンプ編集</title>
        <meta name = "description" content = "スタンプ編集">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/form8.css" rel = "stylesheet">
        <script src = "./js/set-stamp2.js"></script>
        <script src = "./js/set-img-button2.js"></script>
        <script src = "./js/slide-stamp2.js"></script>
        <script src = "./js/check-submit.js"></script>
    </head>
    <body>
        <header class = "header">
            <?php include('./header2.php'); ?>
        </header>

        <main class = "main">

            <p class = "stamp-count-data" style = "display: none;"><?php echo (string)$stamp_number; ?></p>

            <div class = "main-inner">
                <h1>スタンプ編集</h1>
                <form class = "main-inner-form-stamp" method = "POST" enctype = "multipart/form-data" action = "edit_stamp.php" onSubmit = "return checkSubmit4();">
                    <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id ?>">
                    <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass ?>">
                    <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name ?>">

                    <p class = "main-inner-form-title">タイトル：<input type = "text" name = "img_title" value = "<?php echo $stamp_title; ?>" required></p>
                    <p class = "main-inner-form-limit">有効期限：<input type = "date" name = "date_limit" value = "<?php echo $stamp_limit; ?>" required></p>

                    <hr class = "main-inner-form-line">

                    <?php if ($stamp_type == 'normal') { ?>

                        <div class = "stamp-normal">
                            <div class = "form-img-box">
                                <p>スタンプ：</p>
                                <button class = "stamp-normal-img-button" type = "button">ファイルを選択</button>
                            </div>
                            <img class = "stamp-normal-img-preview" src = "<?php echo './images_stamp/' . $stamp_info[0][0] . '_' . $stamp_info[0][1] . '.' . $stamp_info[0][4] . '?version=' . uniqid(); ?>">
                            <p class = "stamp-normal-notice">※画像を変更すると、ユーザーがこれまでに取得したスタンプ画像も変更されます。</p>
                        </div>

                    <?php } else { ?>

                        <div class = "stamp-random">
                            <div class = "stamp-random-area">
                                <button class = "stamp-random-left" type = "button">〈</button>
                                <div class = "stamp-random-panel">

                                    <div class = "stamp-prob-title-0">
                                        <div class = "form-img-box">
                                            <p class = "stamp-subtitle-0">スタンプ１：</p>
                                            <button class = "stamp-img-0-button" type = "button">ファイルを選択</button>
                                        </div>
                                        <div class = "stamp-prob-0"><p>確率(%)：<input class = "stamp-prob-0-data" type = "number" name = "prob_data_0" value = "<?php echo $stamp_info[0][3]; ?>" required><p></div>
                                        <img class = "stamp-normal-img-preview-0" src = "<?php echo './images_stamp/' . $stamp_info[0][0] . '_' . $stamp_info[0][1] . '_' . $stamp_info[0][2] . '.' . $stamp_info[0][4] . '?version=' . uniqid(); ?>">
                                    </div>

                                    <div class = "stamp-prob-title-1">
                                        <div class = "form-img-box">
                                            <p class = "stamp-subtitle-1">スタンプ２：</p>
                                            <button class = "stamp-img-1-button" type = "button">ファイルを選択</button>
                                        </div>
                                        <div class = "stamp-prob-1"><p>確率(%)：<input class = "stamp-prob-1-data" type = "number" name = "prob_data_1" value = "<?php echo $stamp_info[1][3]; ?>" required><p></div>
                                        <img class = "stamp-normal-img-preview-1" src = "<?php echo './images_stamp/' . $stamp_info[1][0] . '_' . $stamp_info[1][1] . '_' . $stamp_info[1][2] . '.' . $stamp_info[1][4] . '?version=' . uniqid(); ?>">
                                    </div>

                                    <?php if ($stamp_number > 2) { ?>
                                    <div class = "stamp-prob-title-2">
                                        <div class = "form-img-box">
                                            <p class = "stamp-subtitle-2">スタンプ３：</p>
                                            <button class = "stamp-img-2-button" type = "button">ファイルを選択</button>
                                        </div>
                                        <div class = "stamp-prob-2"><p>確率(%)：<input class = "stamp-prob-2-data" type = "number" name = "prob_data_2" value = "<?php echo $stamp_info[2][3]; ?>" required><p></div>
                                        <img class = "stamp-normal-img-preview-2" src = "<?php echo './images_stamp/' . $stamp_info[2][0] . '_' . $stamp_info[2][1] . '_' . $stamp_info[2][2] . '.' . $stamp_info[2][4] . '?version=' . uniqid(); ?>">
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if ($stamp_number > 3) { ?>
                                    <div class = "stamp-prob-title-3">
                                        <div class = "form-img-box">
                                            <p class = "stamp-subtitle-3">スタンプ４：</p>
                                            <button class = "stamp-img-3-button" type = "button">ファイルを選択</button>
                                        </div>
                                        <div class = "stamp-prob-3"><p>確率(%)：<input class = "stamp-prob-3-data" type = "number" name = "prob_data_3" value = "<?php echo $stamp_info[3][3]; ?>" required><p></div>
                                        <img class = "stamp-normal-img-preview-3" src = "<?php echo './images_stamp/' . $stamp_info[3][0] . '_' . $stamp_info[3][1] . '_' . $stamp_info[3][2] . '.' . $stamp_info[3][4] . '?version=' . uniqid(); ?>">
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if ($stamp_number > 4) { ?>
                                    <div class = "stamp-prob-title-4">
                                        <div class = "form-img-box">
                                            <p class = "stamp-subtitle-4">スタンプ５：</p>
                                            <button class = "stamp-img-4-button" type = "button">ファイルを選択</button>
                                        </div>
                                        <div class = "stamp-prob-4"><p>確率(%)：<input class = "stamp-prob-4-data" type = "number" name = "prob_data_4" value = "<?php echo $stamp_info[4][3]; ?>" required><p></div>
                                        <img class = "stamp-normal-img-preview-4" src = "<?php echo './images_stamp/' . $stamp_info[4][0] . '_' . $stamp_info[4][1] . '_' . $stamp_info[4][2] . '.' . $stamp_info[4][4] . '?version=' . uniqid(); ?>">
                                    </div>
                                    <?php } ?>
                                </div>
                                <button class = "stamp-random-right" type = "button">〉</button>
                            </div>
                            
                            <div class = "stamp-random-count">
                                <button class = "stamp-random-count0" type = "button" style = "display: none; background-color: lightskyblue;"></button>
                                <button class = "stamp-random-count1" type = "button" style = "display: none; background-color: lightgray;"></button>
                                <button class = "stamp-random-count2" type = "button" style = "display: none; background-color: lightgray;"></button>
                                <button class = "stamp-random-count3" type = "button" style = "display: none; background-color: lightgray;"></button>
                                <button class = "stamp-random-count4" type = "button" style = "display: none; background-color: lightgray;"></button>
                            </div>

                            <p class = "stamp-random-notice">※スタンプの個数は変更できません。確率は整数値で設定してください。<br><br>※画像を変更すると、ユーザーがこれまでに取得したスタンプ画像も変更されます。</p>
                            <p class = "stamp-random-alert" style = "display: none;"></p>
                        </div>
                    
                    <?php } ?>

                    <div class = "stam-submit-block">
                        <input class = "stamp_img_id" type = "text" name = "stamp_img_id" value = "<?php echo (string)$stamp_img_id; ?>" style = "display: none;">
                        <input class = "stamp_table_id" type = "text" name = "stamp_table_id" value = "<?php echo (string)$stamp_table_id; ?>" style = "display: none;">
                        
                        <input class = "stamp-info-input" type = "text" name = "stamp-info-input" value = "none" style = "display: none;">
                        <input class = "stamp-info-input-0" type = "text" name = "stamp-info-input-0" value = "none" style = "display: none;">
                        <input class = "stamp-info-input-1" type = "text" name = "stamp-info-input-1" value = "none" style = "display: none;">
                        <input class = "stamp-info-input-2" type = "text" name = "stamp-info-input-2" value = "none" style = "display: none;">
                        <input class = "stamp-info-input-3" type = "text" name = "stamp-info-input-3" value = "none" style = "display: none;">
                        <input class = "stamp-info-input-4" type = "text" name = "stamp-info-input-4" value = "none" style = "display: none;">

                        <input class = "stamp-normal-img" type = "file" name = "img_data" accept = "image/*" style = "display: none;">
                        <input class = "stamp-img-0" type = "file" name = "img_data_0" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-1" type = "file" name = "img_data_1" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-2" type = "file" name = "img_data_2" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-3" type = "file" name = "img_data_3" accept = "image/*" style = "display: none">
                        <input class = "stamp-img-4" type = "file" name = "img_data_4" accept = "image/*" style = "display: none">
                        <div class = "stamp-submit-block-back"></div>
                        <input class = "stamp-number" type = "text" name = "stamp-number" value = "<?php echo (string)$stamp_number; ?>" style = "display: none;">

                        <input class = "stamp-submit-button" type = "submit" value = "更新">
                    </div>

                </form>
            </div>
        </main>

        <footer class = "footer">
            <?php include('./footer2.php'); ?>
        </footer>
    </body>
</html>
