<?php
include('./source.php');

$table_id = $_POST['table_id'];
$my_book_name = $_POST['my_book_name'];
$my_book_id = $_POST['my_book_id'];
$set_number = $_POST['my_book_question_num'];
$new_word = $_POST['new_word'];
$new_answer = $_POST['new_answer'];
$word = $_POST['word'];
$answer = $_POST['answer'];
$set_type = $_POST['submit'];
$my_table_id = $table_id . '_' . $my_book_id;
$my_list_id = $table_id . '_my_book_list';

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($set_type == 'add') {
        $sql = 'INSERT INTO ' . $my_table_id . ' (id, word, answer) VALUE(' . $set_number . ', \'' . $new_word . '\', \'' . $new_answer . '\')';
        $dbh->query($sql);
    } else if ($set_type == 'change') {
        $sql = 'UPDATE ' . $my_table_id . ' SET word = \'' . $new_word . '\', answer = \'' . $new_answer . '\' WHERE id = ' . $set_number;
        $dbh->query($sql);
    } else if ($set_type == 'delete') {
        $sql = 'DELETE FROM ' . $my_table_id . ' WHERE id = ' . $set_number;
        $dbh->query($sql);
    } else if ($set_type == 'delete_all') {
        $sql = 'DROP TABLE IF EXISTS ' . $my_table_id;
        $dbh->query($sql);
        $sql = 'DELETE FROM ' . $my_list_id . ' WHERE book_name = \'' . $my_book_name . '\' AND book_id = \'' . $my_book_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    } else {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    }
    $sql = 'SELECT * FROM ' . $my_table_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $i = 1;
    foreach ($result as $row) {
        $sql = 'UPDATE ' . $my_table_id . ' SET id = ' . (string)$i . ' WHERE id = ' . $row['id'];
        $dbh->query($sql);
        $i += 1;
    }

    $dbh = null;
    header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
