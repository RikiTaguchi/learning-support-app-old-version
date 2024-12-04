<?php
include('./source.php');
include('../info_db_.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'UPDATE info_director SET director_name = \'removed\', director_id = \'removed\', director_pass = \'removed\' WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);

    $dbh = null;

    setcookie('director_id', '', time() - 30);
    setcookie('director_pass', '', time() - 30);

    header('Location: https://wordsystemforstudents.com/error.php?type=32', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}
