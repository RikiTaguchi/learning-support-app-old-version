<?php
include('./source.php');
include('../info_db.php');

$new_director_id = $_POST['new_director_id'];
$new_director_name = $_POST['new_director_name'];
$new_director_pass = $_POST['new_director_pass'];

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_director WHERE director_id = :director_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $director_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // IDの重複チェック
    $sql = 'SELECT * FROM info_director';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row['director_id'] == $new_director_id) {
            if ($row['director_id'] != $director_id) {
                $dbh = null;
                header('Location: ../error.php?type=31', true, 307);
                exit;
            }
        }
    }

    // 管理者情報の更新
    $sql = 'UPDATE info_director SET director_id = :director_id, director_name = :director_name, director_pass = :director_pass WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':director_id', $new_director_id, PDO::PARAM_STR);
    $stmt->bindParam(':director_name', $new_director_name, PDO::PARAM_STR);
    $stmt->bindParam(':director_pass', $new_director_pass, PDO::PARAM_STR);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    $director_id = $new_director_id;
    $director_name = $new_director_name;
    $director_pass = $new_director_pass;

    // cookieに管理者情報を保存
    setcookie('director_id', $director_id, time() + (60 * 60 * 24 * 60));
    setcookie('director_pass', $director_pass, time() + (60 * 60 * 24 * 60));

    header('Location: ../error.php?type=30', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: ../error.php?type=24', true, 307);
    exit;
}
