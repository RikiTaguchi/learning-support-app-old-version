<?php
include('./source.php');
include('./info_db.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // 復習リストの削除
    $sql = 'DELETE FROM info_feedback WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    // MyBook(index)の削除
    $sql = 'DELETE FROM info_my_book_index WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    // MyBook(data)の削除
    $sql = 'DELETE FROM info_my_book_data WHERE table_id = :table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    // アカウントの削除
    $sql = 'DELETE FROM info_account WHERE login_id = :login_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->execute();

    // スタンプ情報の削除
    $sql = 'DELETE FROM info_stamp WHERE user_table_id = :user_table_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_table_id', $table_id, PDO::PARAM_INT);
    $stmt->execute();

    // スタンプ情報の更新
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

    // Cookieの削除
    setcookie('login_id', '', time() - 30);
    setcookie('user_pass', '', time() - 30);

    header('Location: error.php?type=15', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: error.php?type=2', true, 307);
    exit;
}
