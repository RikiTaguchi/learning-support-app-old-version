<?php
include('./source.php');

$table_id = $_POST['table_id'];
$my_book_name = $_POST['my_book_name'];
$my_book_id = $_POST['my_book_id'];
$my_table_id = $table_id . '_' . $my_book_id;
$my_list_id = $table_id . '_my_book_list';
$new_index = $_POST['new_index'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE ' . $my_list_id . ' SET book_index = \'' . $new_index . '\' WHERE book_id = \'' . $my_book_id . '\'';
    $dbh->query($sql);

    $dbh = null;
    header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
