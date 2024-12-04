<?php
include('./source.php');
include('../info_db_.php');

if ($director_id == '' || $director_pass == '') {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}

if ($director_id == 'removed' || $director_pass == 'removed') {
    header('Location: https://wordsystemforstudents.com/error.php?type=22', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_director WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($director_id == $result['director_id'] && $director_pass == $result['director_pass']) {
        $director_name = $result['director_name'];
        $dbh = null;

        setcookie('director_id', $director_id, time() + (60 * 60 * 24 * 60));
        setcookie('director_pass', $director_pass, time() + (60 * 60 * 24 * 60));

        header('Location: https://wordsystemforstudents.com/director/index_director.php?banner=25', true, 307);
        exit;
    } else {
        $sql = 'SELECT * FROM info_director';
        $stmt = $dbh->query($sql);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dbh = null;
        $check_account = false;
        foreach ($result2 as $row) {
            if ($row['director_id'] == $director_id) {
                $check_account = true;
                break;
            }
        }
        if ($check_account == true) {
            header('Location: https://wordsystemforstudents.com/error.php?type=23', true, 307);
            exit;
        } else {
            header('Location: https://wordsystemforstudents.com/error.php?type=22', true, 307);
            exit;
        }
    }
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}
