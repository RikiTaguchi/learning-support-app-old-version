<?php
include('./source.php');
include('../info_db_.php');

$book_id = $_GET['book_id'];
$book_name = $_GET['book_name'];
$start = $_GET['start'];
$end = $_GET['end'];
$questions_num = $_GET['questions_num'];
$number = [];
$words = [];
$answers = [];
$select1 = [];
$select2 = [];
$select3 = [];
$select4 = [];
$type = [];

for ($i = 1; $i <= $questions_num; $i++) {
    $data_key = 'data' . $i;
    $number[] = $_GET[$data_key];
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    foreach ($number as $n) {
        $sql = 'SELECT * FROM ' . $book_id . ' WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $n, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
    header('Location: ../error.php?type=2', true, 307);
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
            <?php
            echo '<form method = "post" action = "index_director.php">';
                echo '<input type = "text" name = "director_id" style = "display: none;" value = "' . $director_id . '">';
                echo '<input type = "text" name = "director_pass" style = "display: none;" value = "' . $director_pass . '">';
                echo '<input type = "text" name = "director_name" style = "display: none;" value = "' . $director_name . '">';
                echo '<button class = "header-logo" type = "submit">';
                    echo '<img src = "./images/logo-1.png" alt = "ロゴ画像">';
                echo '</button>';
            echo '</form>';
            echo '<div class = "header-inner-menu">' . PHP_EOL;
            echo '<p class = "header-inner-menu-title">' . $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題</p>'. PHP_EOL;
            echo '<div class = "header-inner-menu-button">';
            echo '<form method = "post" action = "answer2.php?book_id=' . $book_id . '&book_name=' . $book_name . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
            for ($i = 1; $i <= $questions_num; $i++) {
                echo 'data' . $i . '=' . $number[$i - 1];
                if ($i < $questions_num) {
                    echo '&';
                }
                else {
                    echo '">';
                    echo '<input type = "text" name = "director_id" style = "display: none;" value = "' . $director_id . '">';
                    echo '<input type = "text" name = "director_pass" style = "display: none;" value = "' . $director_pass . '">';
                    echo '<input type = "text" name = "director_name" style = "display: none;" value = "' . $director_name . '">';
                    echo '<button class = "make-link-button" type = "submit">';
                        echo '<p>解答</p>';
                    echo '</button>';
                    echo '</form>';
                }
            }
            make_link('入力フォームに戻る', 'form9.php', [$director_name, $director_id, $director_pass]);
            echo '</div>';
            echo '</div>';
            ?>
        </div>
    </header>
    <main>
        <div class = "main-inner">
        <p class = "main-inner-title">
            <?php
            echo $book_name . ' / #' . $start . '~' . $end . ' / ' . $questions_num . '題<br>';
            ?>
        </p>
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
