<?php
include('./source.php');

$new_login_id = $_POST['new_login_id'];
$new_user_name = $_POST['new_user_name'];
$new_user_pass = $_POST['new_user_pass'];
$new_user_api_key = $_POST['new_user_api_key'];

try {
    $dbh = new PDO('mysql:host=localhost;dbname=xs192380_db2;charset=utf8', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM info_account';
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row['login_id'] == $new_login_id) {
            if ($row['login_id'] != $login_id) {
                $dbh = null;
                
                header('Location: https://wordsystemforstudents.com/error.php?type=5', true, 307);
                exit;
            }
        }
    }
    $sql = '';
    if ($new_user_api_key == '') {
        $sql = 'UPDATE info_account SET user_name = \'' . $new_user_name . '\', login_id = \'' . $new_login_id . '\', user_pass = \'' . $new_user_pass . '\' WHERE login_id = \'' . $login_id . '\'';
    } else {
        $sql = 'UPDATE info_account SET user_name = \'' . $new_user_name . '\', login_id = \'' . $new_login_id . '\', user_pass = \'' . $new_user_pass . '\', api_key = \'' . $new_user_api_key . '\' WHERE login_id = \'' . $login_id . '\'';
    }
    $stmt = $dbh->query($sql);
    $dbh = null;
    $login_id = $new_login_id;
    $user_name = $new_user_name;
    $user_pass = $new_user_pass;
    $user_api_key = $new_user_api_key;

    setcookie('login_id', $login_id, time() + (60 * 60 * 24 * 60));
    setcookie('user_pass', $user_pass, time() + (60 * 60 * 24 * 60));

    header('Location: https://wordsystemforstudents.com/error.php?type=4', true, 307);
    exit;

} catch (PDOException $e) {
    header('Location: https://wordsystemforstudents.com/error.php?type=2', true, 307);
    exit;
}
?>
