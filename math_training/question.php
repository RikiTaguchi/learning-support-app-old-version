<?php
include('./source2.php');

$type = $_POST['type'];
$level = $_POST['level'];
$question_number = $_POST['question_number'];
$question_count = $_POST['question_count'];
$question_correct = $_POST['question_correct'];
$param_feedback = $_POST['param_feedback'];

$time_h = $_POST['passed_time_h'];
$time_m = $_POST['passed_time_m'];
$time_s = $_POST['passed_time_s'];

if ($_POST['start_time'] == '') {
    $start_time = strtotime(date('Y-m-d H:i:s'));
} else {
    $start_time = strtotime($_POST['start_time']);
}

include('./source.php');
include('./info1.php');
include('./info2.php');
include('./info3.php');
include('./info4.php');
include('./info5.php');
include('./info6.php');

$info = set_question($type, $level);
$title = $info[0];
$question = $info[1];
$input = $info[2];
$answer = $info[3];
$answer_text = $info[4];

if (strval($question_number) < 1 || strval($question_number) > 100) {
    header('Location: https://wordsystemforstudents.com/error.php?type=40', true, 307);
    exit;
}

$question_text = $question;
$question_text = str_replace('<', 'A', $question_text);
$question_text = str_replace('>', 'B', $question_text);
$question_text = str_replace(' ', 'C', $question_text);
$question_text = str_replace('"', 'D', $question_text);
$question_text = str_replace(PHP_EOL, '', $question_text);

$answer_text = str_replace('<', 'A', $answer_text);
$answer_text = str_replace('>', 'B', $answer_text);
$answer_text = str_replace(' ', 'C', $answer_text);
$answer_text = str_replace('"', 'D', $answer_text);
$answer_text = str_replace(PHP_EOL, '', $answer_text);

$feedback_text = $question_text . 'E' . $answer_text . 'E' . $question_count;
?>

<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>計算トレーニング</title>
        <meta name = "description" content = "計算トレーニング">
        <meta name = "viewport" content = "width=device-width">
        <link href = "./css/question.css" rel = "stylesheet">
        <script type = "text/javascript" asyncsrc = "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=MML_SVG"></script>
        <script src = "./js/set_input.js"></script>
        <script src = "./js/count_time.js"></script>
    </head>
    <body>
        <div class = "info_area" style = "display: none;">
            <p class = "info_type"><?php echo $type; ?></p>
            <p class = "info_level"><?php echo $level; ?></p>
            <p class = "answer_count"><?php echo (string)count($answer) ?></p>
            <p class = "input_target"><?php echo '0'; ?></p>
            <p class = "question_correct"><?php echo $question_correct; ?></p>
            <p class = "question_count"><?php echo $question_count; ?></p>
            <p class = "question_number"><?php echo $question_number; ?></p>
            <?php
            for ($i = 0; $i < count($answer); $i += 1) {
                $answer_text = implode('', str_split(strval($answer[$i])));
                echo '<div>';
                echo '<math>';
                    echo '<mn class = "answer_' . (string)$i . '">' . $answer_text . '</mn>';
                echo '</math>';
                echo '</div>';
            }
            ?>
            <p class = "info_feedback"><?php echo $feedback_text; ?></p>
            <p class = "param_feedback"><?php echo $param_feedback; ?></p>
            <p class = "info_start_time"><?php echo $start_time; ?></p>
            <p class = "info_passed_time"></p>
        </div>

        <div class = "count_area">
            <p><?php echo $title . ' / レベル' . (string)$level . ' / ' . $question_number . '題'; ?></p>
        </div>
        
        <div class = "question_panel">
            <div class = "question_subpanel">
                <p class = "question_title"><?php echo '[ 問' . $question_count . ' ]'; ?></p>
                <div class = "question_area"><?php echo $question; ?></div>
            </div>
            <div class = "input_area"><?php echo $input; ?></div>

            <div class = "effect_area">
                <img class = "img_correct" src = "./images/correct2.png" style = "display: none;">
                <img class = "img_incorrect" src = "./images/incorrect2.png" style = "display: none;">
                <img class = "img_pass" src = "./images/pass2.png" style = "display: none;">
            </div>
        </div>

        <div class = "time_area">
            <p class = "info_passed_time_h"><?php echo $time_h; ?></p>
            <p>：</p>
            <p class = "info_passed_time_m"><?php echo $time_m; ?></p>
            <p>：</p>
            <p class = "info_passed_time_s"><?php echo $time_s; ?></p>
        </div>

        <div class = "time_area2">
            <p class = "info_passed_time_h_result"></p>
            <p>：</p>
            <p class = "info_passed_time_m_result"></p>
            <p>：</p>
            <p class = "info_passed_time_s_result"></p>
        </div>

        <div class = "keyboard_area">
            <button class = "button_1 button_element">１</button>
            <button class = "button_2 button_element">２</button>
            <button class = "button_3 button_element">３</button>
            <button class = "button_4 button_element">４</button>
            <button class = "button_5 button_element">５</button>
            <button class = "button_6 button_element">６</button>
            <button class = "button_7 button_element">７</button>
            <button class = "button_8 button_element">８</button>
            <button class = "button_9 button_element">９</button>
            <button class = "button_0 button_element">０</button>
            <button class = "button_10 button_element">＋</button>
            <button class = "button_11 button_element">−</button>
        </div>

        <div class = "button_area">
            <button class = "button_b">←</button>
            <button class = "button_r">リセット</button>
            <button class = "button_n">→</button>
        </div>

        <div class = "check_area">
            <button class = "button_p">パス</button>
            <button class = "button_a">回答</button>

            <form class = "form_next_area" method = "POST" action = "question.php">
                <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                <input type = "text" name = "type" value = "<?php echo $type; ?>" style = "display: none;">
                <input type = "text" name = "level" value = "<?php echo $level; ?>" style = "display: none;">
                <input type = "text" name = "question_number" value = "<?php echo $question_number; ?>" style = "display: none;">
                <input type = "text" name = "question_count" value = "<?php echo (string)(intval($question_count) + 1); ?>" style = "display: none;">
                <input class = "form_correct" type = "text" name = "question_correct" value = "<?php echo $question_correct; ?>" style = "display: none;">
                <input class = "param_feedback_input" type = "text" name = "param_feedback" value = "" style = "display: none;">
                <input class = "start_time" type = "text" name = "start_time" value = "<?php echo date('Y-m-d H:i:s', $start_time); ?>" style = "display: none;">
                <input class = "passed_time_h" type = "text" name = "passed_time_h" value = "" style = "display: none;">
                <input class = "passed_time_m" type = "text" name = "passed_time_m" value = "" style = "display: none;">
                <input class = "passed_time_s" type = "text" name = "passed_time_s" value = "" style = "display: none;">
                <button class = "button_c" type = "submit" name = "submit" style = "pointer-events: none; background-color: gray;">次へ</button>
            </form>

            <form class = "result_area" method = "post" action = "../math_result.php" style = "display: none;">
                <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
                <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
                <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
                <input type = "text" name = "type" value = "<?php echo $type; ?>" style = "display: none;">
                <input type = "text" name = "level" value = "<?php echo $level; ?>" style = "display: none;">
                <input type = "text" name = "question_number" value = "<?php echo $question_number; ?>" style = "display: none;">
                <input type = "text" name = "question_count" value = "<?php echo (string)(intval($question_count) + 1); ?>" style = "display: none;">
                <input class = "form_correct2" type = "text" name = "question_correct" value = "<?php echo $question_correct; ?>" style = "display: none;">
                <input class = "param_feedback_input2" type = "text" name = "param_feedback" value = "" style = "display: none;">
                <input class = "finish_time_h" type = "text" name = "finish_time_h" value = "" style = "display: none;">
                <input class = "finish_time_m" type = "text" name = "finish_time_m" value = "" style = "display: none;">
                <input class = "finish_time_s" type = "text" name = "finish_time_s" value = "" style = "display: none;">
                <button class = "button_l" type = "submit" name = "submit" style = "pointer-events: none; background-color: gray;">結果へ</button>
            </form>
        </div>

        <form class = "back_area" method = "post" action = "../index.php">
            <input type = "text" name = "login_id" value = "<?php echo $login_id; ?>" style = "display: none;">
            <input type = "text" name = "user_pass" value = "<?php echo $user_pass; ?>" style = "display: none;">
            <input type = "text" name = "user_name" value = "<?php echo $user_name; ?>" style = "display: none;">
            <button class = "back_button" type = "submit">ホームに戻る</button>
        </form>
    </body>
</html>
