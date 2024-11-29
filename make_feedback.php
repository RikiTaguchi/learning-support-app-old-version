<?php
include('./source.php');

$book_name = $_POST['book_name'];
$n = (int)$_POST['next_number'];
$questions_num = $_POST['questions_num'];
$number = [];
$check = false;
for ($i = 0; $i < $questions_num; $i ++) {
    $number[] = $_POST['question_number' . $i]; 
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_name = $result['table_id'] . '_feedback';

    $sql = 'SELECT * FROM ' . $table_name . ' WHERE book_name = \'' . $book_name . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($number[$n] == $row['question_number']) {
            $check = true;
            break;
        }
    }
    if ($check == false) {
        $insert_data = '\'' . $book_name . '\', ' . $number[$n];
        $sql = 'INSERT INTO ' . $table_name . ' VALUE(' . $insert_data . ')';
        $stmt = $dbh->query($sql);
    }
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if ($_POST['qanda'] == 'a') {
    header('Location: https://wordsystemforstudents.com/training_answer.php', true, 307);
} else {
    header('Location: https://wordsystemforstudents.com/training_next.php', true, 307);
}
