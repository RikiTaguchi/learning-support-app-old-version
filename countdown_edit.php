<?php
include('./source.php');

$new_title = $_POST['user_title'];
$new_date = $_POST['user_date'];
$edit_type = $_POST['edit_type'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    $user_countdown_title = $result['countdown_title'];
    $user_countdown_date = strtotime($result['countdown_date']);
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

if ($edit_type == 'reset') {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET countdown_title = \'\', countdown_date = \'0000-00-00\' WHERE login_id = \'' . $login_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/countdown_set.php', true, 307);
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }
} else {
    try {
        $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'UPDATE info_account SET countdown_title = \'' . $new_title . '\', countdown_date = \'' . $new_date . '\' WHERE login_id = \'' . $login_id . '\'';
        $dbh->query($sql);
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/index.php', true, 307);
    } catch (PDOException $e) {
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    }
}
