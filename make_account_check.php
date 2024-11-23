<?php
include('./source.php');

$user_api_key = $_POST['user_api_key'];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM info_account WHERE login_id = \'' . $login_id . '\'';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['login_id'] != '') {
        $dbh = null;
        header('Location: https://wordsystemforstudents.com/error.php?type=10', true, 307);
        exit;
    }

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
            $table_name = $table_id . '_feedback';
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
                book_name VARCHAR(255),
                question_number INT(11)
            )';
            $dbh->query($sql);

            $table_name = $table_id . '_my_book_list';
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
                book_name VARCHAR(255),
                book_id VARCHAR(255),
                book_index VARCHAR(255)
            )';
            $dbh->query($sql);
            break;
        }
    }

    $insert_data = '\'' . $user_name . '\', \'' . $login_id . '\', \'' . $user_pass . '\', \'' . $table_id . '\', \'' . $user_api_key . '\', \'\', \'\', \'\'';
    $sql = 'INSERT INTO info_account VALUE(' . $insert_data . ')';
    $stmt = $dbh->query($sql);
    
    $dbh = null;

    setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
    setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

    header('Location: https://wordsystemforstudents.com/error.php?type=14', true, 307);

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>