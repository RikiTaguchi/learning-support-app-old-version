<?php
include('./source.php');

try {
    $dbh = new PDO('mysql:host=' . $db_host  . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 既存アカウントとのログインID重複をチェック
    if ($result['login_id'] != '') {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=10', true, 307);
        exit;
    }

    // 既存アカウントとのテーブルID重複をチェック
    $i = 0;
    $sql = 'SELECT table_id FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    while ($i == 0) {
        $table_id = rand(100000, 999999);
        $check_id = true;
        foreach ($result as $row) {
            if ($table_id == $row['table_id']) {
                $check_id = false;
                break;
            }
        }
        if ($check_id == true) {
            break;
        }
    }

    // アカウントの追加
    $insert_data = '\'' . $user_name . '\', \'' . $login_id . '\', \'' . $user_pass . '\', ' . (string)$table_id . ', \'\', \'\', \'\'';
    $sql = 'INSERT INTO info_account VALUE(' . $insert_data . ')';
    $stmt = $dbh->query($sql);
    $dbh = null;

    // Cookieにアカウント情報を保存
    setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
    setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

    header('Location: https://wordsystemforstudents.com/error.php?type=14', true, 307);

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
