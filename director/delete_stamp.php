<?php
include('./source.php');
include('../info_db_.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];
    $img_id = (int)$_POST['img_id'];
    
    $sql = 'UPDATE info_image SET stamp_state = \'removed\', date_limit = \'1000-01-01\' WHERE table_id = :table_id AND img_id = :img_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->bindParam(':img_id', $img_id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;

    header('Location: detail_stamp.php?banner=35', true, 307);
    exit;
} catch (PDOException $e) {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}
