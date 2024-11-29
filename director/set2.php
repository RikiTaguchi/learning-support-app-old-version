<?php
include('./source2.php');

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

function check_form($book, $start, $end, $number, $limit) {
    if ($book == '' || $book == 'n') {
        return 1;
    } else if (($start >= 1 && $end <= $limit && ($end - $start + 1) >= $number && $number > 0) == false) {
        return 2;
    } else {
        return 3;
    }
}

$limit = 0;
if ($_POST['book_name'] == '1') {
    $book_name = 'ターゲット1400';
    $table_name = 'target_1400';
    $limit = 1400;
}
else if ($_POST['book_name'] == '2') {
    $book_name = 'ターゲット1900';
    $table_name = 'target_1900';
    $limit = 1900;
}
else if ($_POST['book_name'] == '3') {
    $book_name = 'システム英単語';
    $table_name = 'system_English';
    $limit = 2027;
}
else if ($_POST['book_name'] == '4') {
    $book_name = '速読英熟語(熟語)';
    $table_name = 'rapid_Reading';
    $limit = 855;
}
else if ($_POST['book_name'] == '5') {
    $book_name = 'Vintage';
    $table_name = 'Vintage';
    $limit = 852;
}
else if ($_POST['book_name'] == '6') {
    $book_name = 'パス単(3級)';
    $table_name = 'pass_3';
    $limit = 1200;
}
else if ($_POST['book_name'] == '7') {
    $book_name = 'パス単(準２級)';
    $table_name = 'pass_pre2';
    $limit = 1500;
}
else if ($_POST['book_name'] == '8') {
    $book_name = 'パス単(２級)';
    $table_name = 'pass_2';
    $limit = 1700;
}
else if ($_POST['book_name'] == '9') {
    $book_name = 'パス単(準１級)';
    $table_name = 'pass_pre1';
    $limit = 1900;
}
else if ($_POST['book_name'] == '10') {
    $book_name = 'パス単(１級)';
    $table_name = 'pass_1';
    $limit = 2100;
}
else if ($_POST['book_name'] == '11') {
    $book_name = 'ゲットスルー2600';
    $table_name = 'get_Through_2600';
    $limit = 2100;
}
else if ($_POST['book_name'] == '12') {
    $book_name = '明光暗記テキスト(単語)';
    $table_name = 'meiko_original_1';
    $limit = 453;
}
else if ($_POST['book_name'] == '13') {
    $book_name = '明光暗記テキスト(文法)';
    $table_name = 'meiko_original_2';
    $limit = 100;
}
else if ($_POST['book_name'] == '14') {
    $book_name = 'TOEIC金のフレーズ';
    $table_name = 'gold_phrase';
    $limit = 1000;
}
else if ($_POST['book_name'] == '15') {
    $book_name = 'みるみる古文単語300';
    $table_name = 'kobun300';
    $limit = 300;
}
else if ($_POST['book_name'] == '16') {
    $book_name = '古文単語315';
    $table_name = 'kobun315';
    $limit = 315;
}
else if ($_POST['book_name'] == '17') {
    $book_name = '古文単語330';
    $table_name = 'kobun330';
    $limit = 330;
}
else if ($_POST['book_name'] == '' || $_POST['book_name'] == 'n') {
    $book_name = 'none';
    $table_name = 'none';
    $limit = 0;
}

$start = $_POST['start'];
$end = $_POST['end'];
$questions_num = $_POST['questions_num'];
$order = $_POST['order'];

if (check_form($_POST['book_name'], $start, $end, $questions_num, $limit) == 1) {
    header('Location: https://wordsystemforstudents.com/error.php?type=36', true, 307);
    exit;
} else if (check_form($_POST['book_name'], $start, $end, $questions_num, $limit) == 2) {
    header('Location: https://wordsystemforstudents.com/error.php?type=37', true, 307);
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
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    foreach ($number as $n) {
        $sql = 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $n;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $words[] = $result['word'];
        $answers[] = $result['answer'];
        if ($table_name == 'Vintage' || $table_name == 'meiko_original_2') {
            $select1[] = $result['select1'];
            $select2[] = $result['select2'];
            $select3[] = $result['select3'];
            $select4[] = $result['select4'];
            $type[] = $result['type'];
        }
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
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
            <form method = "post" action = "index_director.php">
                <input type = "text" name = "director_id" style = "display: none;" value = "<?php echo $director_id; ?>">
                <input type = "text" name = "director_pass" style = "display: none;" value = "<?php echo $director_pass; ?>">
                <input type = "text" name = "director_name" style = "display: none;" value = "<?php echo $director_name; ?>">
                <button class = "header-logo" type = "submit">
                    <img src = "./images/logo-1.png" alt = "ロゴ画像">
                </button>
            </form>
            <div class = "header-inner-menu">
                <?php
                echo '<p class = "header-inner-menu-title">' . $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題</p>'. PHP_EOL;
                echo '<div class = "header-inner-menu-button">';
                    echo '<form method = "post" action = "answer2.php?db_id=' . $db_id . '&book_name=' . $book_name . '&table_name=' . $table_name . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
                    for ($i = 1; $i <= $questions_num; $i++) {
                        echo 'data' . $i . '=' . $number[$i - 1];
                        if ($i < $questions_num) {
                            echo '&';
                        }
                        else {
                            echo '">';
                            echo '<input type = "text" name = "director_name" style = "display: none;" value = "' . $director_name . '">';
                            echo '<input type = "text" name = "director_id" style = "display: none;" value = "' . $director_id . '">';
                            echo '<input type = "text" name = "director_pass" style = "display: none;" value = "' . $director_pass . '">';
                            echo '<button class = "make-link-button" type = "submit">';
                                echo '<p>解答</p>';
                            echo '</button>';
                            echo '</form>';
                        }
                    }
                    make_link('入力フォームに戻る', 'form9.php', [$director_name, $director_id, $director_pass]);
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
                    if ($table_name == 'Vintage') {
                        echo '<p class = "main-inner-word-change-sub">';
                    } else {
                        echo '<p class = "main-inner-word-change">';
                    }
                } else {
                    if ($table_name == 'Vintage') {
                        echo '<p class = "main-inner-word-sub">';
                    } else {
                        echo '<p class = "main-inner-word">';
                    }
                }
                if ($table_name == 'Vintage' || $table_name == 'meiko_original_2') {
                    if ($type[$i] == 0 or $type[$i] == 1) {
                        echo $i + 1 . '.<br>　' . $words[$i] . '<br><br>　　①' . $select1[$i] . '　②' . $select2[$i] . '　③' . $select3[$i] . '　④' . $select4[$i] . '<br><hr>';
                    } else {
                        echo $i + 1 . '.<br>　' . $words[$i] . '<br><br><br><hr>';
                    }
                    echo '</p>';
                } else {
                    echo $i + 1 . '. ' . $words[$i] . ' (' . $number[$i] . ')<br><hr>';
                    echo '</p>';
                }
            }
            ?>
        </div>
    </main>
</body>
</html>
