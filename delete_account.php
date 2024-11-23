<?php
include('./source.php');

$my_book_id = [];
$table_name = [];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $table_name[] = $table_id . '_my_book_list';
    $table_name[] = $table_id . '_feedback';

    $sql = 'SELECT * FROM ' . $table_name[0];
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $table = $table_id . '_' . $row['book_id'];
        $sql = 'DROP TABLE ' . $table;
        $dbh->query($sql);
    }

    $sql = 'DROP TABLE ' . $table_name[0] . ', ' . $table_name[1];
    $dbh->query($sql);

    $sql = 'DELETE FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $dbh->query($sql);

    $sql = 'DELETE FROM info_stamp WHERE user_table_id = \'' . $table_id . '\'';
    $dbh->query($sql);

    $sql = 'SELECT * FROM info_stamp';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $i => $row) {
        $sql = '';
        $sql = 'UPDATE info_stamp SET id = ' . (string)($i + 1) . ' WHERE id = ' . (string)$row['id'];
        $dbh->query($sql);
    }

    $dbh = null;

    setcookie('login_id', '', time() - 30);
    setcookie('user_pass', '', time() - 30);

    header('Location: https://wordsystemforstudents.com/error.php?type=15', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>
