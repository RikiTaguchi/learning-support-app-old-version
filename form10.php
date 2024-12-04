<?php
include('./source.php');
include('./info_db.php');
include('./banner.php');
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>計算トレーニング</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/form10.css" rel = "stylesheet">
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
                <h1 class = "main-title">計算トレーニング</h1>
                <form class = "main-inner-form" method = "post" action = "./math_training/question.php">
                    <p class = "main-inner-form-type">
                        単元　：
                        <select name = "type" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "1">正負の数(中1)</option>
                            <option value = "2">一次方程式(中1)</option>
                            <option value = "3">連立方程式(中2)</option>
                            <option value = "4">展開(中3)</option>
                            <option value = "5">因数分解(中3)</option>
                            <option value = "6">平方根(中3)</option>
                        </select>
                    </p>
                    <p class = "main-inner-form-level">
                        レベル：
                        <select name = "level" required>
                            <option value = "n" hidden>選択してください</option>
                            <option value = "1">Very Easy</option>
                            <option value = "2">Easy</option>
                            <option value = "3">Normal</option>
                            <option value = "4">Hard</option>
                            <option value = "5">Very Hard</option>
                        </select>
                    </p>
                    <p class = "main-inner-form-number">
                        出題数：
                        <input type = "number" name = "question_number" required>
                    </p>
                    <input type = "number" name = "question_count" value = 1 style = "display: none;">
                    <input type = "number" name = "question_correct" value = 0 style = "display: none;">
                    <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                    <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                    <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                    <input type = "text" name = "param_feedback" value = "" style = "display: none;">
                    <input type = "text" name = "passed_time_h" value = "00" style = "display: none;">
                    <input type = "text" name = "passed_time_m" value = "00" style = "display: none;">
                    <input type = "text" name = "passed_time_s" value = "00" style = "display: none;">
                    <button class = "main-inner-form-button" type = "submit">開始</button>
                </form>
            </div>
        </main>
        <footer class = "footer">
            <?php include('./footer.php'); ?>
        </footer>
    </body>
</html>
