<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $table_id = $result['table_id'];

    // 復習リストの削除
    $sql = 'DELETE FROM info_feedback WHERE table_id = ' . $table_id;
    $dbh->query($sql);

    // MyBook(index)の削除
    $sql = 'DELETE FROM info_my_book_index WHERE table_id = ' . $table_id;
    $dbh->query($sql);

    // MyBook(data)の削除
    $sql = 'DELETE FROM info_my_book_data WHERE table_id = ' . $table_id;
    $dbh->query($sql);

    // アカウントの削除
    $sql = 'DELETE FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $dbh->query($sql);

    // スタンプ情報の削除
    $sql = 'DELETE FROM info_stamp WHERE user_table_id = \'' . $table_id . '\'';
    $dbh->query($sql);

    // スタンプ情報の更新
    $sql = 'SELECT * FROM info_stamp';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $i => $row) {
        $sql = 'UPDATE info_stamp SET id = ' . (string)($i + 1) . ' WHERE id = ' . (string)$row['id'];
        $dbh->query($sql);
    }

    $dbh = null;

    // Cookieの削除
    setcookie('login_id', '', time() - 30);
    setcookie('user_pass', '', time() - 30);

    header('Location: https://wordsystemforstudents.com/error.php?type=15', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
