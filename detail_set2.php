<?php
include('./source.php');

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$new_memo = $_POST['new_memo'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // メモ欄の更新
    $sql = 'UPDATE info_my_book_index SET memo = \'' . $new_memo . '\' WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND book_name = \'' . $book_name . '\'';
    $dbh->query($sql);
    $dbh = null;
    header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
