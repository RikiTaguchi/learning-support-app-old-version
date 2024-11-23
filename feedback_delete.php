<?php
include('./source.php');

$db_name = $_POST['db_name'];
$delete_all = $_POST['delete_all'];
if ($delete_all != 'all') {
    $n = (int)$_POST['next_number'];
    $questions_num = $_POST['questions_num'];
    $number = [];
    $check = false;
    for ($i = 0; $i < $questions_num; $i ++) {
        $number[] = $_POST['question_number' . $i]; 
    }
}

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_name = $result['table_id'] . '_feedback';

    if ($delete_all != 'all') {
        $sql = 'DELETE FROM ' . $table_name . ' WHERE book_name = \'' . $db_name . '\' AND question_number = \'' . $number[$n] . '\'';
        $stmt = $dbh->query($sql);
    } else {
        $sql = 'DELETE FROM ' . $table_name . ' WHERE book_name = \'' . $db_name . '\'';
        $stmt = $dbh->query($sql);
    }
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if ($delete_all == 'all') {
    header('Location: https://wordsystemforstudents.com/index.php', true, 307);
} else if ($_POST['qanda'] == 'a') {
    header('Location: https://wordsystemforstudents.com/feedback_answer.php', true, 307);
} else {
    header('Location: https://wordsystemforstudents.com/feedback_next.php', true, 307);
}
?>