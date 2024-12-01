<?php
include('./source.php');

$table_id = $_POST['table_id'];
$book_name = $_POST['book_name'];
$book_id = $_POST['book_id'];
$new_book_name = $_POST['new_book_name'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_my_book_index WHERE table_id = ' . $table_id;
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 既存book_nameとの重複チェック
    $check_book_name = false;
    foreach ($result as $row) {
        if ($row == null) {
            break;
        } else if ($new_book_name == $row['book_name'] && $book_id != $row['book_id']) {
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
        // book_nameの更新
        $sql = 'UPDATE info_my_book_index SET book_name = \'' . $new_book_name . '\' WHERE table_id = ' . $table_id . ' AND book_id = ' . $book_id . ' AND book_name = \'' . $book_name . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/detail.php', true, 307);
    }
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
