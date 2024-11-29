<?php
include('./source.php');

$table_id = $_POST['table_id'];
$my_book_name = $_POST['my_book_name'];
$my_book_id = $_POST['my_book_id'];
$my_table_id = $table_id . '_' . $my_book_id;
$my_list_id = $table_id . '_my_book_list';
$new_book_name = $_POST['new_book_name'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM ' . $my_list_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $check_book_name = false;
    foreach ($result as $row) {
        if ($row == null) {
            break;
        } else if ($new_book_name == $row['book_name'] && $my_book_id != $row['book_id']) {
            $check_book_name = true;
            break;
        }
    }

    if ($check_book_name == true) {
        $dbh = null;
        if ($_POST['info_banner'] == 'update') {
            header('Location: https://wordsystemforstudents.com/error.php?type=7', true, 307);
            exit;
        } else {
            header('Location: https://wordsystemforstudents.com/error.php?type=11', true, 307);
            exit;
        }
    } else {
        $sql = 'UPDATE ' . $my_list_id . ' SET book_name = \'' . $new_book_name . '\' WHERE book_id = \'' . $my_book_id . '\'';
        $dbh->query($sql);

        $dbh = null;
        header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
    }
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
