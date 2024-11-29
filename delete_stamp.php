<?php
include('./source.php');

$delete_stamp_id = $_POST['delete_stamp_id'];
$user_table_id = '';
$delete_stamp_id_set = '';

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;

    $user_table_id = $result['table_id'];
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_stamp WHERE user_table_id = \'' . $user_table_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $i => $row) {
        if ($i == $delete_stamp_id) {
            $delete_stamp_id_set = (string)$row['id'];
            break;
        }
    }

    if ($delete_stamp_id_set != '') {
        $sql = 'DELETE FROM info_stamp WHERE id = ' . $delete_stamp_id_set;
        $dbh->query($sql);
    } else {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
        exit;
    }

    $sql = 'SELECT * FROM info_stamp';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $i => $row) {
        $sql = '';
        $sql = 'UPDATE info_stamp SET id = ' . (string)($i + 1) . ' WHERE id = ' . (string)$row['id'];
        $dbh->query($sql);
    }

    $dbh = null;
    header('Location: https://wordsystemforstudents.com/detail_stamp.php?banner=33', true, 307);
    exit;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
