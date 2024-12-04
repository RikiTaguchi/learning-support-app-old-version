<?php
include('./source.php');
include('./info_db.php');

$delete_stamp_id = $_POST['delete_stamp_id'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_table_id = $result['table_id'];
    $dbh = null;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_stamp WHERE user_table_id = :user_table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_table_id', $user_table_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $i => $row) {
        if ($i == $delete_stamp_id) {
            $delete_stamp_id_set = (string)$row['id'];
            break;
        }
    }

    if ($delete_stamp_id_set != '') {
        $sql = 'DELETE FROM info_stamp WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $delete_stamp_id_set, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $dbh = null;
        header('Location: error.php?type=2', true, 307);
        exit;
    }

    $sql = 'SELECT * FROM info_stamp';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $i => $row) {
        $id_new = $i + 1;
        $sql = 'UPDATE info_stamp SET id = :id_new WHERE id = :id_pre';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id_new', $id_new, PDO::PARAM_INT);
        $stmt->bindParam(':id_pre', $row['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    $dbh = null;
    header('Location: detail_stamp.php?banner=33', true, 307);
    exit;
} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
