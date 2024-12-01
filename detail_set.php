<?php
include('./source.php');

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$question_number = $_POST['question_number'];
$new_word = $_POST['new_word'];
$new_answer = $_POST['new_answer'];
$word = $_POST['word'];
$answer = $_POST['answer'];
$set_type = $_POST['submit'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($set_type == 'add') { // 追加
        $sql = 'INSERT INTO info_my_book_data (table_id, book_id, word, answer, question_number) VALUE(' . $table_id . ', \'' . $book_id . '\', \'' . $new_word . '\', \'' . $new_answer . '\', ' . $question_number . ')';
        $dbh->query($sql);
    } else if ($set_type == 'change') { // 更新
        $sql = 'UPDATE info_my_book_data SET word = \'' . $new_word . '\', answer = \'' . $new_answer . '\' WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND question_number = ' . $question_number;
        $dbh->query($sql);
    } else if ($set_type == 'delete') { // 削除
        $sql = 'DELETE FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND question_number = ' . $question_number;
        $dbh->query($sql);
    } else if ($set_type == 'delete_all') { // 全削除
        $sql = 'DELETE FROM info_my_book_index WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id;
        $dbh->query($sql);
        $sql = 'DELETE FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id;
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    } else { // エラー
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    }

    // インデックスの修正
    $sql = 'SELECT * FROM info_my_book_data WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    foreach ($result as $row) {
        $sql = 'UPDATE info_my_book_data SET question_number = ' . (string)$i . ' WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND question_number = ' . (string)$row['question_number'];
        $dbh->query($sql);
        $i += 1;
    }

    $dbh = null;
    header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
