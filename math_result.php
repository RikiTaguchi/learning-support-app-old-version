<?php
include('./source.php');

$type = $_POST['type'];
$level = $_POST['level'];
$question_number = $_POST['question_number'];
$question_count = $_POST['question_count'];
$question_correct = $_POST['question_correct'];

$score = ceil(($question_correct / $question_number) * 100);
if ($score > 100) {
    $score = 100;
} else if ($score < 0) {
    $score = 0;
}

$param_feedback = $_POST['param_feedback'];
$info_feedback = explode('F', $param_feedback);
$list_feedback = [];
for ($i = 1; $i < count($info_feedback); $i += 1) {
    $data0 = explode('E', $info_feedback[$i]);

    $data1 = str_replace('A', '<', $data0[0]);
    $data1 = str_replace('B', '>', $data1);
    $data1 = str_replace('C', ' ', $data1);
    $data1 = str_replace('D', '"', $data1);

    $data2 = str_replace('A', '<', $data0[1]);
    $data2 = str_replace('B', '>', $data2);
    $data2 = str_replace('C', ' ', $data2);
    $data2 = str_replace('D', '"', $data2);

    $data3 = $data0[2];

    $list_feedback[] = [$data1, $data2, $data3];
}

$finish_time_h = $_POST['finish_time_h'];
$finish_time_m = $_POST['finish_time_m'];
$finish_time_s = $_POST['finish_time_s'];
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>計算トレーニング</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/header.css" rel = "stylesheet">
        <link href = "./css/footer.css" rel = "stylesheet">
        <link href = "./css/body.css" rel = "stylesheet">
        <link href = "./css/math_result.css" rel = "stylesheet">
        <script type = "text/javascript" asyncsrc = "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=MML_SVG"></script>
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
                <p class = "main-inner-time-score"><?php echo 'Time　' . $finish_time_h . '：' . $finish_time_m . '：' . $finish_time_s; ?></p>
                <p class = "main-inner-result1"><?php echo $question_number . ' 問中 ' . $question_correct . ' 問正解'; ?></p>
                <p class = "main-inner-result2">正答率</p>
                <p class = "main-inner-result3"><?php echo (string)$score . '<font size = "7">%</font>'; ?></p>

                <p class = "main-inner-msg">
                    <?php
                    if (count($list_feedback) == 0) {
                        echo '次のレベルにも挑戦してみましょう！';
                    } else {
                        echo '間違えた問題は、よく復習しましょう。';
                    }
                    ?>
                </p>
                <?php
                foreach ($list_feedback as $value) {
                    echo '<div class = "feedback-block">';
                        echo '<p class = "feedback-title">[問' . $value[2] . ']</p>';
                        echo '<div class = "feedback-question">' . $value[0] . '</div>';
                        echo '<div class = "feedback-answer">' . $value[1] . '</div>';
                    echo '</div>';
                    echo '<hr class = "feedback-line">';
                }
                ?>

                <form class = "back_area" method = "post" action = "index.php">
                    <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                    <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                    <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                    <button class = "back_button" type = "submit">ホームに戻る</button>
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
