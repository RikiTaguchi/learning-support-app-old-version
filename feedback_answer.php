<?php
include('./source.php');

$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$start = $_POST['start'];
$end = $_POST['end'];
$order = $_POST['order'];
$questions_num = $_POST['questions_num'];
$n = (int)$_POST['next_number'];
$number = [];
for ($i = 0; $i < $questions_num; $i ++) {
    $number[] = $_POST['question_number' . $i]; 
}
$selected = $_POST['submit'];
$word = 'word';
$answer = 'answer';
$select1 = 'select1';
$select2 = 'select2';
$select3 = 'select3';
$select4 = 'select4';
$type = 'type';

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    $sql = 'SELECT * FROM info_feedback WHERE table_id = ' . $table_id . ' AND book_id = \'' . $book_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $check_feedback = false;
    foreach ($result as $row) {
        if ($number[$n] == $row['question_number']) {
            $check_feedback = true;
            break;
        }
    }

    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $book_id_list = ['target_1400', 'target_1900', 'system_English', 'rapid_Reading', 'Vintage', 'pass_3', 'pass_pre2', 'pass_2', 'pass_pre1', 'pass_1', 'get_Through_2600', 'meiko_original_1', 'meiko_original_2', 'gold_phrase', 'kobun300', 'kobun315', 'kobun330'];
    if (array_search($book_id, $book_id_list) == false) {
        $sql = 'SELECT * FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND question_number = ' . (string)$number[(int)$n];
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = ' . (string)$number[(int)$n];
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $word = $result['word'];
    $answer = $result['answer'];
    if ($book_id == 'Vintage' || $book_id == 'meiko_original_2') {
        $select1 = $result['select1'];
        $select2 = $result['select2'];
        $select3 = $result['select3'];
        $select4 = $result['select4'];
        $type = $result['type'];
        if ($type == 2 || $type == 3 || $type == 4) {
            $answer_text = $_POST['input-text'];
        }
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<head lang = "ja">
    <meta charset = "UTF-8">
    <title>復習モード</title>
    <meta name = "description" content = "復習モード">
    <meta name = "viewport" content = "width=device-width">
    <link href = "./css/training_answer.css" rel = "stylesheet">
    <link href = "./css/header.css" rel = "stylesheet">
    <link href = "./css/footer.css" rel = "stylesheet">
    <link href = "./css/body.css" rel = "stylesheet">
    <script src = "./js/toggle-menu.js"></script>
    <script src = "./js/change-answer.js"></script>
    <script src = "./js/toggle-feedback2.js"></script>
</head>
<body>
    <header class = "header">
        <?php include('./header.php'); ?>
        <div class = "main-notice-feedback"><p class = "main-notice-feedback-text"></p></div>
        <p class = "info-login-type" style = "display: none;"><?php echo $login_id; ?></p>
    </header>
    <main>
        <div class = "main-inner">
            <div class = "main-inner-contents">
                <?php
                echo '<p class = "info-bookname" style = "display: none;">' . $book_name . '</p>';
                echo '<p class = "main-inner-title">' . $book_name . ' / 復習モード</p>' . PHP_EOL;
                echo '<p class = "main-inner-count">' . (string)(((int)$n) + 1) . ' / ' . $questions_num . '</p>';
                if ($book_id == 'Vintage' || $book_id == 'meiko_original_2') {
                    echo '<p class = "main-inner-word-select">' . str_replace('<br><br>', '<br>', $word) . '</p>' . PHP_EOL;
                    echo '<div class = "main-inner-answer-menu">';
                    if ($type == 0) {
                        if ($selected == $answer) {
                            echo '<img class = "correct_img" src = "./images/correct.png" alt = "正解">';
                        } else {
                            echo '<img class = "incorrect_img" src = "./images/incorrect.png" alt = "不正解">';
                        }
                        echo '<p class = "main-inner-type-0">answer: </p>';
                        if ($answer == 1) {
                            echo '<p class = "main-inner-selecter">① ' . $select1 . ' (' . $number[(int)$n] . ')</p>';
                        } else if ($answer == 2) {
                            echo '<p class = "main-inner-selecter">② ' . $select2 . ' (' . $number[(int)$n] .  ')</p>';
                        } else if ($answer == 3) {
                            echo '<p class = "main-inner-selecter">③ ' . $select3 . ' (' . $number[(int)$n] .  ')</p>';
                        } else if ($answer == 4) {
                            echo '<p class = "main-inner-selecter">④ ' . $select4 . ' (' . $number[(int)$n] .  ')</p>';
                        }
                    } else if ($type == 1) {
                        if ($selected == substr($answer, 0, 1)) {
                            echo '<img class = "correct_img" src = "./images/correct.png" alt = "正解">';
                        } else {
                            echo '<img class = "incorrect_img" src = "./images/incorrect.png" alt = "不正解">';
                        }
                        echo '<p class = "main-inner-type-1">answer: </p>';
                        echo '<p class = "main-inner-selecter">' . $answer . ' (' . $number[(int)$n] .  ')</p>';
                    } else {
                        if ($answer == $answer_text) {
                            echo '<img class = "correct_img" src = "./images/correct.png" alt = "正解">';
                        } else {
                            echo '<img class = "incorrect_img" src = "./images/incorrect.png" alt = "不正解">';
                            echo '<p class = "main-inner-wrong">' . $answer_text . '</p>';
                        }
                        echo '<p class = "main-inner-type-other">answer: </p>';
                        echo '<p class = "main-inner-selecter-mini">' . $answer . ' (' . $number[(int)$n] . ')</p>';
                    }
                    echo '</div>';
                }
                
                if ($login_id != '000000') {
                    if ($book_id != 'Vintage' && $book_id != 'meiko_original_2') {
                        echo '<form class = "feedback-list" method = "post" action = "feedback_delete.php">';
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                            echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                            echo '<input type = "number" name = "order" value = "' . $order . '">';
                            echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                            for ($i = 0; $i < $questions_num; $i ++) {
                                echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                            }
                            echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                            echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $_POST['input-text'] . '">';
                            echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                            echo '<input type = "text" name = "submit" value = "' . $_POST['submit'] . '">';
                            echo '<input type = "text" name = "qanda" value = "a">';

                            echo '<input type = "text" name = "info-feedback" value = "feedback" style = "display: none;">';
                            echo '<p class = "info-feedback-text" style = "display: none;">' . $_POST['info-feedback'] . '</p>';

                            if ($check_feedback) {
                                echo '<button class = "btn-feedback" type = "submit">復習リストから削除</button>';
                            } else {
                                echo '<button class = "btn-feedback" type = "submit" style = "pointer-events: none;">復習リストから削除済</button>';
                            }

                        echo '</form>';
                    } else {
                        echo '<form class = "feedback-list2" method = "post" action = "feedback_delete.php">';
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                            echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                            echo '<input type = "number" name = "order" value = "' . $order . '">';
                            echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                            for ($i = 0; $i < $questions_num; $i ++) {
                                echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                            }
                            echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                            echo '<input class = "main-inner-answer-menu-order" type = "text" name = "input-text" value = "' . $_POST['input-text'] . '">';
                            echo '<input type = "text" name = "submit_order" value = "' . $_POST['submit_order'] . '">';
                            echo '<input type = "text" name = "submit" value = "' . $_POST['submit'] . '">';
                            echo '<input type = "text" name = "qanda" value = "a">';

                            echo '<input type = "text" name = "info-feedback" value = "feedback" style = "display: none;">';
                            echo '<p class = "info-feedback-text" style = "display: none;">' . $_POST['info-feedback'] . '</p>';

                            if ($check_feedback) {
                                echo '<button class = "btn-feedback" type = "submit">復習リストから削除</button>';
                            } else {
                                echo '<button class = "btn-feedback" type = "submit" style = "pointer-events: none;">復習リストから削除済</button>';
                            }
                        echo '</form>';
                    }
                }
                ?>
                <form class = "next-word" method = "post" action = "feedback_next.php">
                    <?php
                    echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                    echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                    echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                    echo '<input type = "text" name = "book_name" value = "' . $book_name . '">';
                    echo '<input type = "text" name = "book_id" value = "' . $book_id . '">';
                    echo '<input type = "number" name = "order" value = "' . $order . '">';
                    echo '<input type = "number" name = "questions_num" value = "' . $questions_num . '">';
                    for ($i = 0; $i < $questions_num; $i ++) {
                        echo '<input type = "number" name = "question_number' . $i . '" value = "' . $number[$i] . '">';
                    }
                    echo '<input type = "number" name = "next_number" value = "' . (int)$n . '">';
                    echo '<div class = "main-inner-change">';
                    if ($n > 0) {
                        echo '<p><input class = "main-inner-submit-back" type = "submit" name = "submit" value = "Back"></p>';
                    }
                    if ($n < (int)$questions_num - 1) {
                        echo '<p><input class = "main-inner-submit-next" type = "submit" name = "submit" value = "Next"></p>';
                    }
                    echo '</div>';
                    ?>
                </form>
            </div>
        </div>
    </main>
    <footer class = "footer">
        <?php include('./footer.php'); ?>
    </footer>
</body>
</html>
