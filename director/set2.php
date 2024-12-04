<?php
include('./source.php');
include('../info_db_.php');
include('../set_book.php');

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
