<?php
include('./source.php');
include('../info_db_.php');

$stamp_table_id = $_POST['stamp_table_id'];
$stamp_img_id = $_POST['stamp_img_id'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'UPDATE info_image SET stamp_state = \'removed\', date_limit = \'1000-01-01\' WHERE table_id = \'' . (string)$stamp_table_id . '\' AND img_id = \'' . (string)$stamp_img_id . '\'';
    $dbh->query($sql);
    $dbh = null;

    header('Location: https://wordsystemforstudents.com/director/detail_stamp.php?banner=35', true, 307);
    exit;
} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}
