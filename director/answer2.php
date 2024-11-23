<?php
include('./source2.php');

$db_id = $_GET['db_id'];
$book_name = $_GET['book_name'];
$db_name = $_GET['db_name'];
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

for ($i = 1; $i <= $questions_num; $i++) {
    $data_key = 'data' . $i;
    $number[] = $_GET[$data_key];
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_' . $db_id . ';charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    foreach ($number as $n) {
        $sql = 'SELECT * FROM ' . $db_name . ' WHERE id = ' . $n;
        $stmt = $dbh->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $words[] = $result['word'];
        $answers[] = $result['answer'];
        if ($db_name == 'Vintage') {
            $select1[] = $result['select1'];
            $select2[] = $result['select2'];
            $select3[] = $result['select3'];
            $select4[] = $result['select4'];
        }
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head lang = "ja">
    <meta charset = "UTF-8">
    <title>単語テスト(解答)</title>
    <meta name = "description" content = "テスト(解答)">
    <meta name = "viewport" content = "width=device-width">
    <link href = "./css/answer.css" rel = "stylesheet">
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
            echo '<form method = "post" action = "question2.php?db_id=' . $db_id . '&book_name=' . $book_name . '&db_name=' . $db_name . '&start=' . $start . '&end=' . $end . '&questions_num=' . $questions_num . '&';
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
                        echo '<p>問題</p>';
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
                    echo '<p class = "main-inner-word-change">';
                } else {
                    echo '<p class = "main-inner-word">';
                }
                echo $i + 1 . '.　　' . $answers[$i] . ' (' . $number[$i] . ')<br>';
                echo '</p>';
            }
        ?>
        </div>
    </main>
</body>
</html>