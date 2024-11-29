<?php
include('./source2.php');

$new_director_id = $_POST['new_director_id'];
$new_director_name = $_POST['new_director_name'];
$new_director_pass = $_POST['new_director_pass'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        if ($row['director_id'] == $new_director_id) {
            if ($row['director_id'] != $director_id) {
                $dbh = null;
                header('Location: https://wordsystemforstudents.com/error.php?type=31', true, 307);
                exit;
            }
        }
    }

    $sql = 'UPDATE info_director SET director_name = \'' . $new_director_name . '\', director_id = \'' . $new_director_id . '\', director_pass = \'' . $new_director_pass . '\' WHERE director_id = \'' . $director_id . '\'';
    $stmt = $dbh->query($sql);
    $dbh = null;
    $director_id = $new_director_id;
    $director_name = $new_director_name;
    $director_pass = $new_director_pass;

    setcookie('director_id', $director_id, time() + (60 * 60 * 24 * 60));
    setcookie('director_pass', $director_pass, time() + (60 * 60 * 24 * 60));

    header('Location: https://wordsystemforstudents.com/error.php?type=30', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=24', true, 307);
    exit;
}
