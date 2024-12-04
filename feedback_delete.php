<?php
include('./source.php');
include('./info_db.php');

$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
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
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    if ($delete_all != 'all') {
        $sql = 'DELETE FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id AND question_number = :question_number';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->bindParam(':question_number', $number[$n], PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $sql = 'DELETE FROM info_feedback WHERE table_id = :table_id AND book_id = :book_id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

if ($delete_all == 'all') {
    header('Location: index.php', true, 307);
} else if ($_POST['qanda'] == 'a') {
    header('Location: feedback_answer.php', true, 307);
} else {
    header('Location: feedback_next.php', true, 307);
}
