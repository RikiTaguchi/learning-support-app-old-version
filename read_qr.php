<?php
include('./source.php');
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>QRコード読取</title>
        <meta name = "description" content = "QRコード読取">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/read_qr.css" rel = "stylesheet">
    </head>
    <body>
        <main class = "main">
            <div id = "wrapper">
                <div class = "msg"><p>QRコードを読み取ってください。</p></div>
                <video id = "video" autoplay muted playsinline></video>
                <canvas id = "camera-canvas"></canvas>
                <canvas id = "rect-canvas"></canvas>
                <form class = "main-form-back" method = "post" action = "detail_stamp.php">
                    <?php
                    echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                    echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                    echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                    ?>
                    <button class = "main-form-back-button" type = "submit"><p>閉じる</p></button>
                </form>
            </div>
            <div id = "main-inner-form-area">
                <form class = "main-form-qr" method = "post" action = "">
                    <?php
                    echo '<input type = "text" name = "user_name" style = "display: none;" value = "' . $user_name . '">';
                    echo '<input type = "text" name = "login_id" style = "display: none;" value = "' . $login_id . '">';
                    echo '<input type = "text" name = "user_pass" style = "display: none;" value = "' . $user_pass . '">';
                    ?>
                    <img class = "main-form-qr-preview" src = "./images/non.png">

                    <div class = "main-form-qr-preview-list">
                        <img class = "main-form-qr-preview-0" src = "./images/roulette.gif">
                    </div>
                    
                    <button class = "main-form-qr-button" type = "submit" style = "display: none;"><p>このスタンプを取得</p></button>
                    <button class = "main-form-qr-button-back" type = "button" style = "display: none;"><p>戻る</p></button>
                </form>
            </div>
            <script src = "./js/jsQR.js"></script>
            <script src = "./js/set-qr.js"></script>
        </main>
    </body>
</html>
