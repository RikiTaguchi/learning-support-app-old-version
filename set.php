<?php
include('./source.php');

function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0) == false) {
        return 2;
    } else {
        return 3;
    }
}

if ($_POST['book_id'] == '1') {
    $book_name = 'ターゲット1400';
    $book_id = 'target_1400';
    $limit = 1400;
}
else if ($_POST['book_id'] == '2') {
    $book_name = 'ターゲット1900';
    $book_id = 'target_1900';
    $limit = 1900;
}
else if ($_POST['book_id'] == '3') {
    $book_name = 'システム英単語';
    $book_id = 'system_English';
    $limit = 2027;
}
else if ($_POST['book_id'] == '4') {
    $book_name = '速読英熟語(熟語)';
    $book_id = 'rapid_Reading';
    $limit = 855;
}
else if ($_POST['book_id'] == '5') {
    $book_name = 'Vintage';
    $book_id = 'Vintage';
    $limit = 852;
}
else if ($_POST['book_id'] == '6') {
    $book_name = 'パス単(3級)';
    $book_id = 'pass_3';
    $limit = 1200;
}
else if ($_POST['book_id'] == '7') {
    $book_name = 'パス単(準２級)';
    $book_id = 'pass_pre2';
    $limit = 1500;
}
else if ($_POST['book_id'] == '8') {
    $book_name = 'パス単(２級)';
    $book_id = 'pass_2';
    $limit = 1700;
}
else if ($_POST['book_id'] == '9') {
    $book_name = 'パス単(準１級)';
    $book_id = 'pass_pre1';
    $limit = 1900;
}
else if ($_POST['book_id'] == '10') {
    $book_name = 'パス単(１級)';
    $book_id = 'pass_1';
    $limit = 2100;
}
else if ($_POST['book_id'] == '11') {
    $book_name = 'ゲットスルー2600';
    $book_id = 'get_Through_2600';
    $limit = 2100;
}
else if ($_POST['book_id'] == '12') {
    $book_name = '明光暗記テキスト(単語)';
    $book_id = 'meiko_original_1';
    $limit = 453;
}
else if ($_POST['book_id'] == '13') {
    $book_name = '明光暗記テキスト(文法)';
    $book_id = 'meiko_original_2';
    $limit = 100;
}
else if ($_POST['book_id'] == '14') {
    $book_name = 'TOEIC金のフレーズ';
    $book_id = 'gold_phrase';
    $limit = 1000;
}
else if ($_POST['book_id'] == '15') {
    $book_name = 'みるみる古文単語300';
    $book_id = 'kobun300';
    $limit = 300;
}
else if ($_POST['book_id'] == '16') {
    $book_name = '古文単語315';
    $book_id = 'kobun315';
    $limit = 315;
}
else if ($_POST['book_id'] == '17') {
    $book_name = '古文単語330';
    $book_id = 'kobun330';
    $limit = 330;
}
else if ($_POST['book_id'] == '' || $_POST['book_id'] == 'n') {
    $book_name = 'none';
    $book_id = 'none';
    $limit = 0;
}
else {
    $book_id = $_POST['book_id'];
    $limit = 0;
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $table_id = $result['table_id'];

        $sql = 'SELECT * FROM info_my_book_index WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $book_name = $row['book_name'];

        if ($book_id == '') {
            header('Location: https://wordsystemforstudents.com/error.php?type=12', true, 307);
            exit;
        }

        $sql = 'SELECT * FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $limit = count($result);

        $dbh = null;
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
}

$start = $_POST['start'];
$end = $_POST['end'];
$questions_num = $_POST['questions_num'];
$order = $_POST['order'];

if (check_form($_POST['book_id'], $start, $end, $questions_num, $limit) == 1) {
    header('Location: https://wordsystemforstudents.com/error.php?type=16', true, 307);
    exit;
} else if (check_form($_POST['book_id'], $start, $end, $questions_num, $limit) == 2) {
    header('Location: https://wordsystemforstudents.com/error.php?type=17', true, 307);
    exit;
}

$number = [];
$words = [];
$answers = [];
$select1 = [];
$select2 = [];
$select3 = [];
$select4 = [];
$type = [];

if ($order == 1) {
    $i = 1;
    while ($i <= $questions_num) {
        $sample = rand($start, $end);
        $check = 0;
        foreach ($number as $x) {
            if ($sample == $x) {
                $check = 1;
            }
        }
        if ($check == 0) {
            $number[] = $sample;
            $i++;
        }
    }
}
else if ($order == 2) {
    for ($i = $start; $i <= $end; $i++) {
        $number[] = $i;
    }
}
else {
    header('Location: https://wordsystemforstudents.com/error.php?type=12', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $book_id_list = ['target_1400', 'target_1900', 'system_English', 'rapid_Reading', 'Vintage', 'pass_3', 'pass_pre2', 'pass_2', 'pass_pre1', 'pass_1', 'get_Through_2600', 'meiko_original_1', 'meiko_original_2', 'gold_phrase', 'kobun300', 'kobun315', 'kobun330'];
    foreach ($number as $n) {
        if (array_search($book_id, $book_id_list) == false) {
            $sql = 'SELECT * FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND question_number = ' . (string)$n;
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = ' . (string)$n;
            $stmt = $dbh->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $words[] = $result['word'];
        $answers[] = $result['answer'];
        if ($book_id == 'Vintage' || $book_id == 'meiko_original_2') {
            $select1[] = $result['select1'];
            $select2[] = $result['select2'];
            $select3[] = $result['select3'];
            $select4[] = $result['select4'];
            $type[] = $result['type'];
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
    <title>単語テスト(問題)</title>
    <meta name = "description" content = "テスト(問題)">
    <meta name = "viewport" content = "width=device-width">
    <link href = "./css/set.css" rel = "stylesheet">
    <link href = "./css/set_print.css" rel = "stylesheet" media = "print">
</head>
<body>
    <header>
        <div class = "header-inner">
            <form method = "post" action = "index.php">
                <?php
                echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                ?>
                <button class = "header-logo" type = "submit">
                    <img src = "./images/logo-1.png" alt = "ロゴ画像">
                </button>
            </form>
            <div class = "header-inner-menu">
                <?php
                echo '<p class = "header-inner-menu-title">' . $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題</p>'. PHP_EOL;
                echo '<div class = "header-inner-menu-button">';
                    echo '<form method = "post" action = "answer.php?book_name=' . $book_name . '&book_id=' . $book_id . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
                    for ($i = 1; $i <= $questions_num; $i++) {
                        echo 'data' . $i . '=' . $number[$i - 1];
                        if ($i < $questions_num) {
                            echo '&';
                        }
                        else {
                            echo '">';
                            echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
                            echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
                            echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
                            echo '<button class = "make-link-button" type = "submit">';
                                echo '<p>解答</p>';
                            echo '</button>';
                            echo '</form>';
                        }
                    }
                    make_link('入力フォームに戻る', 'form.php', [$user_name, $login_id, $user_pass]);
                ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class = "main-inner">
            <p class = "main-inner-title"><?php echo $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題<br>'; ?></p>
            <?php
            for ($i = 0; $i < $questions_num; $i++) {
                if (($i + 1) % 10 == 0) {
                    if ($book_id == 'Vintage') {
                        echo '<p class = "main-inner-word-change-sub">';
                    } else {
                        echo '<p class = "main-inner-word-change">';
                    }
                } else {
                    if ($book_id == 'Vintage') {
                        echo '<p class = "main-inner-word-sub">';
                    } else {
                        echo '<p class = "main-inner-word">';
                    }
                }
                if ($book_id == 'Vintage' || $book_id == 'meiko_original_2') {
                    if ($type[$i] == 0 or $type[$i] == 1) {
                        echo $i + 1 . '.　' . str_replace('<br><br>', '<br>　　', $words[$i]) . '<br><br>　　①' . $select1[$i] . '　②' . $select2[$i] . '　③' . $select3[$i] . '　④' . $select4[$i] . '<br><hr>';
                    } else {
                        echo $i + 1 . '.　' . str_replace('<br><br>', '<br>　　', $words[$i]) . '<br><br><br><hr>';
                    }
                    echo '</p>';
                }
                else {
                    echo $i + 1 . '. ' . str_replace('<br>', ' / ', $words[$i]) . ' (' . $number[$i] . ')<br><hr>';
                    echo '</p>';
                }
            }
            ?>
        </div>
    </main>
</body>
</html>
