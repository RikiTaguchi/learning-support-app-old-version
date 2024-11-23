<?php
include('./source.php');

$new_memo = $_POST['user_memo'];
$user_memo = '';
$edit_type = $_POST['edit_type'];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_memo = $result['memo'];
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if ($edit_type == 'reset1') {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET memo = \'\' WHERE login_id = \'' . $login_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/memo_set.php', true, 307);
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
} else if ($edit_type == 'reset2') {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET memo = \'\' WHERE login_id = \'' . $login_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
} else {
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET memo = \'' . $new_memo . '\' WHERE login_id = \'' . $login_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    }
}
?>